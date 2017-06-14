<?php
/**
 * Created by PhpStorm.
 * User: joeldg
 * Date: 4/6/17
 * Time: 10:35 PM
 */

namespace Bowhead\Util;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

/**
 * Class BrokersUtil - some extra utils
 * @package Bowhead\Util
 */
class BrokersUtil
{
    public function curlUrl($url)
    {
        $curl = curl_init();
        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FRESH_CONNECT => 1,
            CURLOPT_HTTPHEADER     => array(
                "cache-control: no-cache"
            ),
        );
        curl_setopt_array($curl, $options);
        $response = curl_exec($curl);

        if ($response === false) {
            $error   = curl_errno($curl);
            $message = curl_error($curl);
            curl_close($curl);
        }
        #$statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        return $response;
    }

    /**
     * @return string
     * Generate a unique GUID
     * probably don't use this.
     */
    public function guid(){
        if (function_exists('com_create_guid')){
            return com_create_guid();
        }else{
            mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);// "-"
            // "{"  chr(123)
            $uuid =  substr($charid, 0, 8).$hyphen
                .substr($charid, 8, 4).$hyphen
                .substr($charid,12, 4).$hyphen
                .substr($charid,16, 4).$hyphen
                .substr($charid,20,12);// "}"  chr(125)
            return $uuid;
        }
    }

    /**
     * @return string
     * we don't need this.. probably don't use.
     */
    public function generate_id() {
        return base_convert(time()+mt_rand(1,99), 10 , 36);
    }

    /**
     * @param     $key
     * @param     $value
     * @param int $time
     *
     * @return int
     */
    public function cacheStore($key, $value, $time=180, $tag='bitfinix')
    {
        $value = base64_encode(serialize($value));
        \Cache::tags([$tag])->add($key, $value, $time);
        return 1;
    }

    /**
     * @param $key
     *
     * @return mixed
     */
    public function cacheCheck($key)
    {
        return \Cache::has($key);
    }

    /**
     * @param $key
     *
     * @return string
     */
    public function cacheGet($key)
    {
        echo "in cacheGet\n";
        $value = \Cache::get($key);
        return serialize(base64_encode($value));
    }

    /**
     *  This is just as a reference for how to use the cache
     */
    public function storage()
    {
        \Cache::has('key'); # does key exist
        \Cache::get(); # get the value of key
        \Cache::pull('key'); # get and delete
        \Cache::put('key',$amount, $minutes); # add/update
        \Cache::add('key', 'value', $minutes); # Store If Not Present

        \Cache::increment('key', $amount=1); # increase by $amount
        \Cache::decrement('key', $amount=1); # decrease by $amount

        \Cache::remember('users', $minutes, $default); # Retrieve & Store

        \Cache::forever('key', 'value'); # perm store
        \Cache::forget('key'); # remove perm
        \Cache::flush(); # remove everything

        # tags
        \Cache::tags(['people', 'artists'])->put('John', $john, $minutes);
        $john = Cache::tags(['people', 'artists'])->get('John');
        Cache::tags(['people', 'authors'])->flush();
    }

    /**
     * @param $datas
     *
     * @return array
     *
     *      used by getRecentData
     */
    public function organizePairData($datas)
    {
        $ret['date']   = [];
        $ret['low']    = [];
        $ret['high']   = [];
        $ret['open']   = [];
        $ret['close']  = [];
        $ret['volume'] = [];

        $ret = array();
        foreach ($datas as $data) {
            $ret['date'][]   = $data->buckettime;
            $ret['low'][]    = $data->low;
            $ret['high'][]   = $data->high;
            $ret['open'][]   = $data->open;
            $ret['close'][]  = $data->close;
            $ret['volume'][] = $data->volume;
        }
        foreach($ret as $key => $rettemmp) {
            $ret[$key] = array_reverse($rettemmp);
        }
        return $ret;
    }

    /**
     * @param $datas
     *
     * @return array
     *
     *  only useful if you pull historical from 1broker
     */
    public function organizeOnebrokerData($datas)
    {
        $ret = array();
        foreach ($datas as $data) {
            $ret['date'][]   = $data['date'];
            $ret['low'][]    = $data['l'];
            $ret['high'][]   = $data['h'];
            $ret['open'][]   = $data['o'];
            $ret['close'][]  = $data['c'];
            $ret['volume'][] = 0;
        }
        foreach($ret as $key => $rettemmp) {
            $ret[$key] = array_reverse($rettemmp);
        }
        return $ret;
    }

    /**
     * @param string $pair
     * @param int    $limit
     *
     * @return array
     */
    public function getRecentData($pair='BTC/USD', $limit=168, $day_data=false, $hour=12, $returnRS=false)
    {
        /**
         *  we need to cache this as many strategies will be
         *  doing identical pulls for signals.
         */
        $key = 'recent::'.$pair.'::'.$limit."::$day_data::$hour::$returnRS";
        if(\Cache::has($key)) {
            return \Cache::get($key);
        }

        $a = \DB::table('bowhead_ohlc')
            ->select(DB::raw('*, unix_timestamp(ctime) as buckettime'))
            ->where('instrument', $pair)
            ->orderby('timeid', 'DESC')
            ->limit($limit)
            ->get();

        if ($returnRS) {
            $ret = $a;
        } else {
            $ret = $this->organizePairData($a);
        }

        \Cache::put($key, $ret, 2);
        return $ret;
    }


    /**
     * @param string $pair
     * @param null   $datetime
     * @param int    $limit
     *
     * @return array
     */
    public function getDateData($pair='BTC/USD', $datetime=null, $limit=168)
    {
        $a = \DB::table('historical')
            ->select('*')
            ->where('pair', $pair)
            ->where('buckettime', '>=', $datetime)
            ->orderby('buckettime', 'ASC')
            ->limit($limit)
            ->get();
        return $this->organizePairData($a);
    }

    /**
     * @param       $arr
     * @param float $LO
     * @param float $HI
     *
     * @return mixed  This is the Knuth version.
     */
    public function normalize($arr, $LO=0.01, $HI=0.99)
    {
        $Min =  2147483647;
        $Max = -2147483647;
        for ($a=0; $a<count($arr); $a++) {
            $Min = min($Min, $arr[$a]);
            $Max = max($Max, $arr[$a]);
        }
        $Mean = 0;
        for ($a=0; $a<count($arr); $a++) {
            $div = $Max-$Min;
            if($div == 0){$div = 1;}
            $arr [$a] = (($arr[$a]-$Min) / ($div)) * ($HI-$LO) % $LO;
            $Mean  = $arr[$a] / count($arr);
        }
        return $arr;
    }
}