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
    public function markOHLC($ticker, $bf = false, $bf_pair = 'BTC/USD')
    {
        $timeid = date('YmdHis'); // 20170530152259 unique for date
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

        /** tick table update */
        $ins = \DB::insert("
            INSERT INTO bowhead_ohlc_tick
            (`instrument`, `timeid`, `open`, `high`, `low`, `close`, `volume`)
            VALUES
            ('$instrument', $timeid, $last_price, $last_price, $last_price, $last_price, $volume)
            ON DUPLICATE KEY UPDATE
            `high`   = CASE WHEN `high` < VALUES(`high`) THEN VALUES(`high`) ELSE `high` END,
            `low`    = CASE WHEN `low` > VALUES(`low`) THEN VALUES(`low`) ELSE `low` END,
            `volume` = VALUES(`volume`),
            `close`  = VALUES(`close`)
        ");

        /** 1m table update **/

        $open1 = null;
        $close1 = null;
        $high1 = null;
        $low1 = null;

        $timeid = date("YmdHi", strtotime($timeid));

        $last1m = \DB::table('bowhead_ohlc_1m')->select(DB::raw('MAX(timeid) AS timeid'))
            ->where('instrument', $bf_pair)
            ->get();

        foreach ($last1m as $last1) {
            $last1timeid = $last1->timeid;
            $last1timeid = date("YmdHi", strtotime($last1timeid));
        }

        if ($last1timeid < $timeid) {

            /* Get High and Low from ticker data for insertion */
            $last1timeids = date("YmdHis", strtotime(date("YmdHi", strtotime("-1 minutes", strtotime("now")))));
            $accum1ma = \DB::table('bowhead_ohlc_tick')->select(DB::raw('MAX(high) as high, MIN(low) as low'))
                ->where('instrument', $bf_pair)
                ->where('timeid', '>=', $last1timeids)
                ->where('timeid', '<=', ($last1timeids + 59))
                ->get();

            foreach ($accum1ma as $accum1a) {
                $high1 = $accum1a->high;
                $low1 = $accum1a->low;
            }


            /* Get Open price from ticker data and last minute */
            $accum1mb = \DB::table('bowhead_ohlc_tick')->select(DB::raw('open AS open'))
                ->where('instrument', $bf_pair)
                ->where('timeid', '>=', $last1timeids)
                ->where('timeid', '<=', ($last1timeids + 59))
                ->limit(1)
                ->get();

            foreach ($accum1mb as $accum1b) {
                $open1 = $accum1b->open;
            }

            /* Get close price from ticker data and last minute */
            $accum1mc = \DB::table('bowhead_ohlc_tick')->select(DB::raw('close AS close'))
                ->where('instrument', $bf_pair)
                ->where('timeid', '>=', $last1timeids)
                ->where('timeid', '<=', ($last1timeids + 59))
                ->orderBy('ctime', 'desc')
                ->limit(1)
                ->get();

            foreach ($accum1mc as $accum1c) {
                $close1 = $accum1c->close;
            }


            if ($open1 && $close1 && $high1 && $low1) {
                $ins = \DB::insert("
            INSERT INTO bowhead_ohlc_1m 
            (`instrument`, `timeid`, `open`, `high`, `low`, `close`, `volume`)
            VALUES
            ('$instrument', $timeid, $open1, $high1, $low1, $close1, $volume)
            ON DUPLICATE KEY UPDATE 
            `high`   = CASE WHEN `high` < VALUES(`high`) THEN VALUES(`high`) ELSE `high` END,
            `low`    = CASE WHEN `low` > VALUES(`low`) THEN VALUES(`low`) ELSE `low` END,
            `volume` = VALUES(`volume`),
            `close`  = VALUES(`close`)
        ");
            }

        }

        /** 5m table update  **/

        $open5 = null;
        $close5 = null;
        $high5 = null;
        $low5 = null;

        $last5m = \DB::table('bowhead_ohlc_5m')->select(DB::raw('MAX(timeid) AS timeid'))
            ->where('instrument', $bf_pair)
            ->get();
        foreach ($last5m as $last5) {
            $last5timeid = $last5->timeid;
            $last5timeid = date("YmdHi", strtotime("+4 minutes", strtotime($last5timeid)));
        }
        if ($last5timeid < $timeid) {
            /* Get High and Low from 1m data for insertion */
            $last5timeids = date("YmdHi", strtotime("-5 minutes", strtotime("now")));
            $accum5ma = \DB::table('bowhead_ohlc_1m')->select(DB::raw('MAX(high) as high, MIN(low) as low'))
                ->where('instrument', $bf_pair)
                ->where('timeid', '>=', $last5timeids)
                ->where('timeid', '<=', ($timeid))
                ->get();

            foreach ($accum5ma as $accum5a) {
                $high5 = $accum5a->high;
                $low5 = $accum5a->low;
            }

            /* Get Open price from 1m data and last 5 minutes */
            $accum5mb = \DB::table('bowhead_ohlc_1m')->select(DB::raw('*'))
                ->where('instrument', $bf_pair)
                ->where('timeid', '>=', $last5timeids)
                ->where('timeid', '<=', ($timeid))
                ->limit(1)
                ->get();
            foreach ($accum5mb as $accum5b) {
                $open5 = $accum5b->open;
            }

            /* Get Close price from 1m data and last 5 minutes */
            $accum5mc = \DB::table('bowhead_ohlc_1m')->select(DB::raw('*'))
                ->where('instrument', $bf_pair)
                ->where('timeid', '>=', $last5timeids)
                ->where('timeid', '<=', ($timeid))
                ->orderBy('ctime', 'desc')
                ->limit(1)
                ->get();
            foreach ($accum5mc as $accum5c) {
                $close5 = $accum5c->close;
            }
            if ($open5 && $close5 && $low5 && $high5) {
                $ins = \DB::insert("
            INSERT INTO bowhead_ohlc_5m 
            (`instrument`, `timeid`, `open`, `high`, `low`, `close`, `volume`)
            VALUES
            ('$instrument', $timeid, $open5, $high5, $low5, $close5, $volume)
            ON DUPLICATE KEY UPDATE 
            `high`   = CASE WHEN `high` < VALUES(`high`) THEN VALUES(`high`) ELSE `high` END,
            `low`    = CASE WHEN `low` > VALUES(`low`) THEN VALUES(`low`) ELSE `low` END,
            `volume` = VALUES(`volume`),
            `close`  = VALUES(`close`)
        ");
            }
        }

        /** 15m table update **/
        $open15 = null;
        $close15 = null;
        $high15 = null;
        $low15 = null;

        $last15m = \DB::table('bowhead_ohlc_15m')->select(DB::raw('MAX(timeid) AS timeid'))
            ->where('instrument', $bf_pair)
            ->get();
        foreach ($last15m as $last15) {
            $last15timeid = $last15->timeid;
            $last15timeid = date("YmdHi", strtotime("+14 minutes", strtotime($last15timeid)));
        }
        if ($last15timeid < $timeid) {
            /* Get High and Low from 5m data for insertion */
            $last15timeids = date("YmdHi", strtotime("-15 minutes", strtotime("now")));
            $accum15ma = \DB::table('bowhead_ohlc_5m')->select(DB::raw('MAX(high) as high, MIN(low) as low'))
                ->where('instrument', $bf_pair)
                ->where('timeid', '>=', $last15timeids)
                ->where('timeid', '<=', ($timeid))
                ->get();

            foreach ($accum15ma as $accum15a) {
                $high15 = $accum15a->high;
                $low15 = $accum15a->low;
            }

            /* Get Open price from 5m data and last 15 minutes */
            $accum15mb = \DB::table('bowhead_ohlc_5m')->select(DB::raw('*'))
                ->where('instrument', $bf_pair)
                ->where('timeid', '>=', $last15timeids)
                ->where('timeid', '<=', ($timeid))
                ->limit(1)
                ->get();
            foreach ($accum15mb as $accum15b) {
                $open15 = $accum15b->open;
            }

            /* Get Close price from 5m data and last 15 minutes */
            $accum15mc = \DB::table('bowhead_ohlc_5m')->select(DB::raw('*'))
                ->where('instrument', $bf_pair)
                ->where('timeid', '>=', $last15timeids)
                ->where('timeid', '<=', ($timeid))
                ->orderBy('ctime', 'desc')
                ->limit(1)
                ->get();
            foreach ($accum15mc as $accum15c) {
                $close15 = $accum15c->close;
            }
            if ($open15 && $close15 && $low15 && $high15) {
                $ins = \DB::insert("
            INSERT INTO bowhead_ohlc_15m 
            (`instrument`, `timeid`, `open`, `high`, `low`, `close`, `volume`)
            VALUES
            ('$instrument', $timeid, $open15, $high15, $low15, $close15, $volume)
            ON DUPLICATE KEY UPDATE 
            `high`   = CASE WHEN `high` < VALUES(`high`) THEN VALUES(`high`) ELSE `high` END,
            `low`    = CASE WHEN `low` > VALUES(`low`) THEN VALUES(`low`) ELSE `low` END,
            `volume` = VALUES(`volume`),
            `close`  = VALUES(`close`)
        ");
            }
        }

        /** 30m table update **/
        $open30 = null;
        $close30 = null;
        $high30 = null;
        $low30 = null;

        $last30m = \DB::table('bowhead_ohlc_30m')->select(DB::raw('MAX(timeid) AS timeid'))
            ->where('instrument', $bf_pair)
            ->get();
        foreach ($last30m as $last30) {
            $last30timeid = $last30->timeid;
            $last30timeid = date("YmdHi", strtotime("+29 minutes", strtotime($last30timeid)));
        }
        if ($last30timeid < $timeid) {
            /* Get High and Low from 15m data for insertion */
            $last30timeids = date("YmdHi", strtotime("-30 minutes", strtotime("now")));
            $accum30ma = \DB::table('bowhead_ohlc_15m')->select(DB::raw('MAX(high) as high, MIN(low) as low'))
                ->where('instrument', $bf_pair)
                ->where('timeid', '>=', $last30timeids)
                ->where('timeid', '<=', ($timeid))
                ->get();

            foreach ($accum30ma as $accum30a) {
                $high30 = $accum30a->high;
                $low30 = $accum30a->low;
            }

            /* Get Open price from 15m data and last 30 minutes */
            $accum30mb = \DB::table('bowhead_ohlc_15m')->select(DB::raw('*'))
                ->where('instrument', $bf_pair)
                ->where('timeid', '>=', $last30timeids)
                ->where('timeid', '<=', ($timeid))
                ->limit(1)
                ->get();
            foreach ($accum30mb as $accum30b) {
                $open30 = $accum30b->open;
            }

            /* Get Close price from 15m data and last 30 minutes */
            $accum30mc = \DB::table('bowhead_ohlc_15m')->select(DB::raw('*'))
                ->where('instrument', $bf_pair)
                ->where('timeid', '>=', $last30timeids)
                ->where('timeid', '<=', ($timeid))
                ->orderBy('ctime', 'desc')
                ->limit(1)
                ->get();
            foreach ($accum30mc as $accum30c) {
                $close30 = $accum30c->close;
            }
            if ($open30 && $close30 && $low30 && $high30) {
                $ins = \DB::insert("
            INSERT INTO bowhead_ohlc_30m 
            (`instrument`, `timeid`, `open`, `high`, `low`, `close`, `volume`)
            VALUES
            ('$instrument', $timeid, $open30, $high30, $low30, $close30, $volume)
            ON DUPLICATE KEY UPDATE 
            `high`   = CASE WHEN `high` < VALUES(`high`) THEN VALUES(`high`) ELSE `high` END,
            `low`    = CASE WHEN `low` > VALUES(`low`) THEN VALUES(`low`) ELSE `low` END,
            `volume` = VALUES(`volume`),
            `close`  = VALUES(`close`)
        ");
            }
        }

        /** 1h table update **/
        $open60 = null;
        $close60 = null;
        $high60 = null;
        $low60 = null;

        $last60m = \DB::table('bowhead_ohlc_1h')->select(DB::raw('MAX(timeid) AS timeid'))
            ->where('instrument', $bf_pair)
            ->get();
        foreach ($last60m as $last60) {
            $last60timeid = $last60->timeid;
            $last60timeid = date("YmdHi", strtotime("+59 minutes", strtotime($last60timeid)));
        }
        if ($last60timeid < $timeid) {
            /* Get High and Low from 30m data for insertion */
            $last60timeids = date("YmdHi", strtotime("-60 minutes", strtotime("now")));
            $accum60ma = \DB::table('bowhead_ohlc_30m')->select(DB::raw('MAX(high) as high, MIN(low) as low'))
                ->where('instrument', $bf_pair)
                ->where('timeid', '>=', $last60timeids)
                ->where('timeid', '<=', ($timeid))
                ->get();

            foreach ($accum60ma as $accum60a) {
                $high60 = $accum60a->high;
                $low60 = $accum60a->low;
            }

            /* Get Open price from 30m data and last 60 minutes */
            $accum60mb = \DB::table('bowhead_ohlc_30m')->select(DB::raw('*'))
                ->where('instrument', $bf_pair)
                ->where('timeid', '>=', $last60timeids)
                ->where('timeid', '<=', ($timeid))
                ->limit(1)
                ->get();
            foreach ($accum60mb as $accum60b) {
                $open60 = $accum60b->open;
            }

            /* Get Close price from 30m data and last 60 minutes */
            $accum60mc = \DB::table('bowhead_ohlc_30m')->select(DB::raw('*'))
                ->where('instrument', $bf_pair)
                ->where('timeid', '>=', $last60timeids)
                ->where('timeid', '<=', ($timeid))
                ->orderBy('ctime', 'desc')
                ->limit(1)
                ->get();
            foreach ($accum60mc as $accum60c) {
                $close60 = $accum60c->close;
            }
            if ($open60 && $close60 && $low60 && $high60) {
                $ins = \DB::insert("
            INSERT INTO bowhead_ohlc_1h 
            (`instrument`, `timeid`, `open`, `high`, `low`, `close`, `volume`)
            VALUES
            ('$instrument', $timeid, $open60, $high60, $low60, $close60, $volume)
            ON DUPLICATE KEY UPDATE 
            `high`   = CASE WHEN `high` < VALUES(`high`) THEN VALUES(`high`) ELSE `high` END,
            `low`    = CASE WHEN `low` > VALUES(`low`) THEN VALUES(`low`) ELSE `low` END,
            `volume` = VALUES(`volume`),
            `close`  = VALUES(`close`)
        ");
            }
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
	$validperiods = 0;
	foreach ($a as $ab) {
	   #echo print_r($ab,1);
	   $array = (array) $ab;
	   $ftime = $array['buckettime'];
	   if ($ptime == null) {
	      $ptime = $ftime;
	   } else {
	 	/** Check for missing periods **/
		if ($periodSize == '1m') {
		   $variance = (int)75;
		} else if ($periodSize == '5m') {
		   $variance = (int)375;
		} else if ($periodSize == '15m') {
		   $variance = (int)1125;
		} else if ($periodSize == '30m') {
		   $variance = (int)2250;
		} else if ($periodSize == '1h') {
		   $variance = (int)4500;
		} else if ($periodSize == '1d') {
		   $variance = (int)108000;
		}
		#echo 'Past Time is '.$ptime.' and current time is '.$ftime."\n";
		$periodcheck = $ptime - $ftime;
		if ((int)$periodcheck > (int)$variance) {
		echo 'YOU HAVE '.$validperiods.' PERIODS OF VALID PRICE DATA OUT OF '.$limit.'. Please ensure price sync is running and wait for additional data to be logged before trying again. Additionally you could use a smaller time period if available.'."\n";
		die();
		}	
		$validperiods++;
	   }
	   $ptime = $ftime;	
	}

        \Cache::put($key, $ret, 2);
        return $ret;
    }
}
