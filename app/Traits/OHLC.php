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

        /** 1m table update **/
        //echo date("Y-m-d h:i:sa")."\n".print_r($ticker);
        $last1m = \DB::table('bowhead_ohlc_1m')->select(DB::raw('MAX(timeid) AS timeid'))
            ->where('instrument', $bf_pair)
            ->get();
        foreach ($last1m as $last1) {
            $last1timeid = $last1->timeid;
        }
        if ($last1timeid < $timeid) {
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
        }

        /** 5m table update  **/

        $last5m = \DB::table('bowhead_ohlc_5m')->select(DB::raw('MAX(timeid) AS timeid'))
            ->where('instrument', $bf_pair)
            ->get();
        foreach ($last5m as $last5) {
            $last5timeid = $last5->timeid;
        }
        if ($last5timeid + 4 < $timeid) {
            $ins = \DB::insert("
            INSERT INTO bowhead_ohlc_5m 
            (`instrument`, `timeid`, `open`, `high`, `low`, `close`, `volume`)
            VALUES
            ('$instrument', $timeid, $last_price, $last_price, $last_price, $last_price, $volume)
            ON DUPLICATE KEY UPDATE 
            `high`   = CASE WHEN `high` < VALUES(`high`) THEN VALUES(`high`) ELSE `high` END,
            `low`    = CASE WHEN `low` > VALUES(`low`) THEN VALUES(`low`) ELSE `low` END,
            `volume` = VALUES(`volume`),
            `close`  = VALUES(`close`)
        ");
        }

        /** 15m table update **/
        $last15m = \DB::table('bowhead_ohlc_15m')->select(DB::raw('MAX(timeid) AS timeid'))
            ->where('instrument', $bf_pair)
            ->get();
        foreach ($last15m as $last15) {
            $last15timeid = $last15->timeid;
        }
        if ($last15timeid + 14 < $timeid) {
            $ins = \DB::insert("
            INSERT INTO bowhead_ohlc_15m 
            (`instrument`, `timeid`, `open`, `high`, `low`, `close`, `volume`)
            VALUES
            ('$instrument', $timeid, $last_price, $last_price, $last_price, $last_price, $volume)
            ON DUPLICATE KEY UPDATE 
            `high`   = CASE WHEN `high` < VALUES(`high`) THEN VALUES(`high`) ELSE `high` END,
            `low`    = CASE WHEN `low` > VALUES(`low`) THEN VALUES(`low`) ELSE `low` END,
            `volume` = VALUES(`volume`),
            `close`  = VALUES(`close`)
        ");
        }

        /** 30m table update **/
        $last30m = \DB::table('bowhead_ohlc_30m')->select(DB::raw('MAX(timeid) AS timeid'))
            ->where('instrument', $bf_pair)
            ->get();
        foreach ($last30m as $last30) {
            $last30timeid = $last30->timeid;
        }
        if ($last30timeid + 29 < $timeid) {
            $ins = \DB::insert("
            INSERT INTO bowhead_ohlc_30m 
            (`instrument`, `timeid`, `open`, `high`, `low`, `close`, `volume`)
            VALUES
            ('$instrument', $timeid, $last_price, $last_price, $last_price, $last_price, $volume)
            ON DUPLICATE KEY UPDATE 
            `high`   = CASE WHEN `high` < VALUES(`high`) THEN VALUES(`high`) ELSE `high` END,
            `low`    = CASE WHEN `low` > VALUES(`low`) THEN VALUES(`low`) ELSE `low` END,
            `volume` = VALUES(`volume`),
            `close`  = VALUES(`close`)
        ");
        }

        /** 1h table update **/
        $last60m = \DB::table('bowhead_ohlc_1h')->select(DB::raw('MAX(timeid) AS timeid'))
            ->where('instrument', $bf_pair)
            ->get();
        foreach ($last60m as $last60) {
            $last60timeid = $last60->timeid;
        }
        if ($last60timeid + 59 < $timeid) {
            $ins = \DB::insert("
            INSERT INTO bowhead_ohlc_1h 
            (`instrument`, `timeid`, `open`, `high`, `low`, `close`, `volume`)
            VALUES
            ('$instrument', $timeid, $last_price, $last_price, $last_price, $last_price, $volume)
            ON DUPLICATE KEY UPDATE 
            `high`   = CASE WHEN `high` < VALUES(`high`) THEN VALUES(`high`) ELSE `high` END,
            `low`    = CASE WHEN `low` > VALUES(`low`) THEN VALUES(`low`) ELSE `low` END,
            `volume` = VALUES(`volume`),
            `close`  = VALUES(`close`)
        ");
        }

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

	$ptime = null;
	foreach ($a as $ab) {
	   #echo print_r($ab,1);
	   $array = (array) $ab;
	   $ftime = $array['buckettime'];	
	   if ($ptime == null) {
	      $ptime = $ftime;
	   } else {
	 	/** Check for missing periods **/
		if ($periodsize = '1m') {
		   $variance = (int)60;
		} else if ($periodsize = '5m') {
		   $variance = (int)300;
		} else if ($periodsize = '15m') {
		   $variance = (int)900;
		} else if ($periodsize = '30m') {
		   $variance = (int)1800;
		} else if ($periodsize = '1h') {
		   $variance = (int)3600;
		} else if ($periodsize = '1d') {
		   $variance = (int)86400;
		}
		#echo 'Past Time is '.$ptime.' and current time is '.$ftime."\n";
		$periodcheck = $ptime - $ftime;
		$variance = 1.5 * $variance;
		#echo 'VARIANCE '.$variance;
		#$echo 'TIMING '.$periodcheck."\n";
		if ((int)$periodcheck > (int)$variance) {
		echo 'MISSING DATA FOR THIS TIME PERIOD SO CANNOT CONTINUE. PLEASE ENSURE PRICE SYNC IS RUNNING AND WAIT FOR ADDITIONAL DATA TO BE LOGGED BEFORE TRYING AGAIN';
		die();
		}	
	   }
	   $ptime = $ftime;	
	}

        \Cache::put($key, $ret, 2);
        return $ret;
    }
}
