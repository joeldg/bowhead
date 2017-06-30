<?php
/**
 * Created by PhpStorm.
 * User: joeldg
 * Date: 6/26/17
 * Time: 4:03 PM
 */
namespace Bowhead\Traits;

use Illuminate\Support\Facades\DB;

trait OHLC
{
    /**
     * @param $ticker
     *
     * @return bool
     */
    public function markOHLC($ticker, $bf=false, $bf_pair='BTC/USD')
    {
        $timeid = date('YmdHi'); // 201705301522 unique for date
        if ($bf) {
            /** Bitfinex websocked */
            $last_price = $ticker[7];
            $volume = $ticker[8];
            $instrument = $bf_pair;

            /** if timeid passed, we use it, otherwise use generated one.. */
            $timeid = ($ticker['timeid'] ?? $timeid);
        } else {
            /** Oanda websocket */
            $ticker = json_decode($ticker, 1);
            $last_price = $ticker['tick']['bid'];
            $instrument = $ticker['tick']['instrument'];
            $volume = 0;
        }
        $ins = \DB::insert("
            INSERT INTO bowhead_ohlc_1m 
            (`instrument`, `timeid`, `open`, `high`, `low`, `close`, `volume`)
            VALUES
            ('$instrument', $timeid, $last_price, $last_price, $last_price, $last_price, $volume)
            ON DUPLICATE KEY UPDATE 
            `high`   = CASE WHEN `high` < VALUES(`high`) THEN VALUES(`high`) ELSE `high` END,
            `low`    = CASE WHEN `low` > VALUES(`low`) THEN VALUES(`low`) ELSE `low` END,
            `volume` = VALUES(`volume`),
            `close`  = VALUES(`close`)
        ");

        $timeidb = 5 * round($timeid / 5);
        $ins = \DB::insert("
            INSERT INTO bowhead_ohlc_5m 
            (`instrument`, `timeid`, `open`, `high`, `low`, `close`, `volume`)
            VALUES
            ('$instrument', $timeidb, $last_price, $last_price, $last_price, $last_price, $volume)
            ON DUPLICATE KEY UPDATE 
            `high`   = CASE WHEN `high` < VALUES(`high`) THEN VALUES(`high`) ELSE `high` END,
            `low`    = CASE WHEN `low` > VALUES(`low`) THEN VALUES(`low`) ELSE `low` END,
            `volume` = VALUES(`volume`),
            `close`  = VALUES(`close`)
        ");

        $timeidc = 15 * round($timeid / 15);
        $ins = \DB::insert("
            INSERT INTO bowhead_ohlc_15m 
            (`instrument`, `timeid`, `open`, `high`, `low`, `close`, `volume`)
            VALUES
            ('$instrument', $timeidc, $last_price, $last_price, $last_price, $last_price, $volume)
            ON DUPLICATE KEY UPDATE 
            `high`   = CASE WHEN `high` < VALUES(`high`) THEN VALUES(`high`) ELSE `high` END,
            `low`    = CASE WHEN `low` > VALUES(`low`) THEN VALUES(`low`) ELSE `low` END,
            `volume` = VALUES(`volume`),
            `close`  = VALUES(`close`)
        ");

        $timeidd = 30 * round($timeid / 30);
        $ins = \DB::insert("
            INSERT INTO bowhead_ohlc_30m 
            (`instrument`, `timeid`, `open`, `high`, `low`, `close`, `volume`)
            VALUES
            ('$instrument', $timeidd, $last_price, $last_price, $last_price, $last_price, $volume)
            ON DUPLICATE KEY UPDATE 
            `high`   = CASE WHEN `high` < VALUES(`high`) THEN VALUES(`high`) ELSE `high` END,
            `low`    = CASE WHEN `low` > VALUES(`low`) THEN VALUES(`low`) ELSE `low` END,
            `volume` = VALUES(`volume`),
            `close`  = VALUES(`close`)
        ");
        $timeide = 59 * round($timeid / 59);
        $ins = \DB::insert("
            INSERT INTO bowhead_ohlc_1h 
            (`instrument`, `timeid`, `open`, `high`, `low`, `close`, `volume`)
            VALUES
            ('$instrument', $timeide, $last_price, $last_price, $last_price, $last_price, $volume)
            ON DUPLICATE KEY UPDATE 
            `high`   = CASE WHEN `high` < VALUES(`high`) THEN VALUES(`high`) ELSE `high` END,
            `low`    = CASE WHEN `low` > VALUES(`low`) THEN VALUES(`low`) ELSE `low` END,
            `volume` = VALUES(`volume`),
            `close`  = VALUES(`close`)
        ");

        return true;
    }

    /**
     * @param $datas
     *
     * @return array
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
     * @param string $pair
     * @param int    $limit
     * @param bool   $day_data
     * @param int    $hour
     * @param string $periodSize
     * @param bool   $returnRS
     *
     * @return array
     */
    public function getRecentData($pair='BTC/USD', $limit=168, $day_data=false, $hour=12, $periodSize='1m', $returnRS=false)
    {
        /**
         *  we need to cache this as many strategies will be
         *  doing identical pulls for signals.
         */
        $key = 'recent::'.$pair.'::'.$limit."::$day_data::$hour::$periodSize";
        if(\Cache::has($key)) {
            return \Cache::get($key);
        }

        $a = \DB::table('bowhead_ohlc_'.$periodSize)
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
}