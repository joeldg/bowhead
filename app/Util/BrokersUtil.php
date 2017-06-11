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
 * Class BrokersUtil - This is a lot of the coinbase stuff here.
 * @package Bowhead\Util
 */
class BrokersUtil
{
    protected $key;
    protected $secret;
    protected $passphrase;
    protected $url; # https://api-public.sandbox.gdax.com or https://api.gdax.com

    function __construct()
    {
        $this->key        = env('CBKEY');
        $this->secret     = env('CBSECRET');
        $this->passphrase = env('CBPASSPHRASE');
        $this->url        = env('CBURL');
    }

    /**
     * @var array
     */
    protected $endpoints = array(
        'accounts'   => array('method' => 'GET', 'uri' => '/accounts'),
        'account'    => array('method' => 'GET', 'uri' => '/accounts/%s'),
        'ledger'     => array('method' => 'GET', 'uri' => '/accounts/%s/ledger'),
        'holds'      => array('method' => 'GET', 'uri' => '/accounts/%s/holds'),
        'place'      => array('method' => 'POST', 'uri' => '/orders'),
        'cancel'     => array('method' => 'DELETE', 'uri' => '/orders/'),
        'orders'     => array('method' => 'GET', 'uri' => '/orders'),
        'order'      => array('method' => 'GET', 'uri' => '/orders/%s'),
        'fills'      => array('method' => 'GET', 'uri' => '/fills'),
        'products'   => array('method' => 'GET', 'uri' => '/products'),
        'book'       => array('method' => 'GET', 'uri' => '/products/%s/book'), // ?level=2
        'ticker'     => array('method' => 'GET', 'uri' => '/products/%s/ticker'),
        'trades'     => array('method' => 'GET', 'uri' => '/products/%s/trades'),
        'stats'      => array('method' => 'GET', 'uri' => '/products/%s/stats'),
        'rates'      => array('method' => 'GET', 'uri' => '/products/%s/candles'),
        'currencies' => array('method' => 'GET', 'uri' =>  '/currencies'),
        'time'       => array('method' => 'GET', 'uri' => '/time'),
        'position'   => array('method' => 'GET', 'uri' => '/position'),
        'reports'    => array('method' => 'GET', 'uri' => '/reports'),
        'coinbase-accounts' => array('method' => 'GET', 'uri' => '/coinbase-accounts'),
    );

    public function getCurr()
    {
        return 1;
    }

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
     * @return mixed
     * get both USD/BTC balances on coinbase
     */
    public function get_balances() {
        $jsonReturn = $this->get_endpoint("accounts");
        #error_log(print_r($jsonReturn,1));
        foreach ($jsonReturn as $ret) {
            $user[$ret['currency']]['id'] = $ret['id'];
            $user[$ret['currency']]['balance'] = (float)$ret['balance'];
            $user[$ret['currency']]['hold'] = (float)$ret['hold'];
            $user[$ret['currency']]['available'] = (float)$ret['available'];
            $user[$ret['currency']]['profile_id'] = $ret['profile_id'];
        }
        #error_log("Balances: USD:" . $user['USD']['balance'] . " BTC: ". $user['BTC']['balance'] . " hold: ". $user['BTC']['hold']);
        return $user;
    }

    /**
     * @param      $point
     * @param null $data
     * @param null $extra
     *
     * @return mixed
     */
    public function get_endpoint($point, $data=null, $extra=null, $instrument='ETH-USD', $method='GET') {
        $timestamp  = time();
        $key = $this->key;
        $passphrase = $this->passphrase;

        extract($this->endpoints[$point]); // provide method and uri
        # TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO
        # TODO do sprintf on uri for instrument/product and other %s
        #
        $uri = sprintf($uri, $instrument);
        #error_log('get_endpoint : '.$uri);
        $uri = $uri . $extra;
        $sig = $this->sign($timestamp, $method . $uri . $data, $this->secret, $instrument);

        $headers = array(
            'User-Agent: GDAX_cl_trader',
            'Content-Type: application/json',
            "CB-ACCESS-KEY: $key",
            "CB-ACCESS-SIGN: $sig",
            "CB-ACCESS-TIMESTAMP: $timestamp",
            "CB-ACCESS-PASSPHRASE: $passphrase",
        );
        #error_log($uri);
        #error_log(print_r($headers,1));
        $apireturn = $this->call($point, $headers, $data, $extra, $instrument, $method);
        return json_decode($apireturn['body'],1);
    }



    /**
     * @param $timestamp
     * @param $data
     * @param $secret
     *
     * @return string
     */
    public function sign($timestamp, $data, $secret) {
        return base64_encode(hash_hmac(
            'sha256',
            $timestamp . $data,
            base64_decode($secret),
            true
        ));
    }

    /**
     * @param        $endpoint
     * @param        $headers
     * @param string $body
     * @param null   $extra
     *
     * @return array
     */
    public function call($endpoint, $headers, $body = '', $extra = null, $instrument='ETH-USD', $method='GET') {
        extract($this->endpoints[$endpoint]);
        $uri = sprintf($uri, $instrument);
        #error_log('call : '.$uri);
        $uri = $uri . $extra;
        $url = $this->url . $uri;
        #error_log($url);
        #error_log($body);
        $curl = curl_init();

        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_RETURNTRANSFER => true,
        );

        $method = strtolower($method);
        if ($method == 'get') {
            $options[CURLOPT_HTTPGET] = 1;
        } else if ($method == 'post') {
            $options[CURLOPT_POST] = 1;
            $options[CURLOPT_POSTFIELDS] = $body;
        } else if ($method == 'delete') {
            $options[CURLOPT_CUSTOMREQUEST] = "DELETE";
        } else if ($method == 'put') {
            $options[CURLOPT_CUSTOMREQUEST] = "PUT";
            $options[CURLOPT_POSTFIELDS] = $body;
        }
        #error_log(print_r($options,1));
        curl_setopt_array($curl, $options);
        $response = curl_exec($curl);
        if ($response === false) {
            $error = curl_errno($curl);
            $message = curl_error($curl);
            curl_close($curl);
            #error_log('NETWORK ERROR', $message . " (" . $error . ")");
        }

        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if($statusCode != 200) {
            error_log('STATUS CODE', $statusCode . ' ' . $response);
        }
        return array( "statusCode" => $statusCode, "body" => $response );
    }

    /**
     * @param       $arr
     * @param float $LO
     * @param float $HI
     *
     * @return mixed
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