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
     * @param $datas
     *
     * @return array
     */
    public function organizePairData($datas, $limit=999)
    {
        $ret = array();
        foreach ($datas as $data) {
            $ret[$data->bh_exchanges_id]['timestamp'][]   = $data->buckettime;
            $ret[$data->bh_exchanges_id]['date'][]   = gmdate("j-M-y", $data->buckettime);
            $ret[$data->bh_exchanges_id]['low'][]    = $data->low;
            $ret[$data->bh_exchanges_id]['high'][]   = $data->high;
            $ret[$data->bh_exchanges_id]['open'][]   = $data->open;
            $ret[$data->bh_exchanges_id]['close'][]  = $data->close;
            $ret[$data->bh_exchanges_id]['volume'][] = $data->volume;
        }
        foreach($ret as $ex => $opt) {
            foreach ($opt as $key => $rettemmp) {
                $ret[$ex][$key] = array_reverse($rettemmp);
                $ret[$ex][$key] = array_slice($ret[$ex][$key], 0, $limit, true);
            }
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
        $connection_name = config('database.default');
        $key = 'recent::'.$pair.'::'.$limit."::$day_data::$hour::$periodSize::$connection_name";
        if(\Cache::has($key)) {
            //return \Cache::get($key);
        }

        $timeslice = 60;
        switch($periodSize) {
            case '1m':
                $timescale = '1 minute';
                $timeslice = 60;
                break;
            case '5m':
                $timescale = '5 minutes';
                $timeslice = 300;
                break;
            case '10m':
                $timescale = '10 minutes';
                $timeslice = 600;
                break;
            case '15m':
                $timescale = '15 minutes';
                $timeslice = 900;
                break;
            case '30m':
                $timescale = '30 minutes';
                $timeslice = 1800;
                break;
            case '1h':
                $timescale = '1 hour';
                $timeslice = 3600;
                break;
            case '4h':
                $timescale = '4 hours';
                $timeslice = 14400;
                break;
            case '1d':
                $timescale = '1 day';
                $timeslice = 86400;
                break;
            case '1w':
                $timescale = '1 week';
                $timeslice = 604800;
                break;
        }
        $current_time = time();
        $offset = ($current_time - ($timeslice * $limit)) -1;

        /**
         *  The time slicing queries in various databases are done differently.
         *  Postgres supports series() mysql does not, timescale has buckets, the others don't etc.
         *  having support for timescaledb is important for the scale of the project.
         *
         *  none of these queries can be done through our eloquent models unfourtunatly.
         */
        if ($connection_name == 'pgsql') {
            if (Config::bowhead_config('TIMESCALEDB')) {
                // timescale query
                $results = DB::select(DB::raw("
                    SELECT time_bucket('$timescale', created_at) buckettime,
                        bh_exchanges_id,
                        first(bid, created_at) as open,
                        last(bid,created_at) as close,
                        first(bid, bid) as low,
                        last(bid,bid) as high,
                        SUM(basevolume) AS volume,
                        AVG(bid) AS avgbid,
                        AVG(ask) AS avgask,
                        AVG(basevolume) AS avgvolume
                    FROM bh_tickers
                    WHERE symbol = '$pair'
                    AND extract(epoch from created_at) > ($offset)
                    GROUP BY bh_exchanges_id, buckettime 
                    ORDER BY buckettime DESC   
                "));
                echo "test:" . $offset;
            } else {
                // regular psql query
                // TODO
                die("TimescaleDB extension required for Postgres. see timescale.com\n");
            }
        } else {
            // mysql query
            $results = DB::select(DB::raw("
              SELECT 
                bh_exchanges_id,
                SUBSTRING_INDEX(GROUP_CONCAT(CAST(bid AS CHAR) ORDER BY created_at), ',', 1 ) AS `open`,
                SUBSTRING_INDEX(GROUP_CONCAT(CAST(bid AS CHAR) ORDER BY bid DESC), ',', 1 ) AS `high`,
                SUBSTRING_INDEX(GROUP_CONCAT(CAST(bid AS CHAR) ORDER BY bid), ',', 1 ) AS `low`,
                SUBSTRING_INDEX(GROUP_CONCAT(CAST(bid AS CHAR) ORDER BY created_at DESC), ',', 1 ) AS `close`,
                SUM(basevolume) AS volume,
                ROUND((CEILING(UNIX_TIMESTAMP(`created_at`) / $timeslice) * $timeslice)) AS buckettime,
                round(AVG(bid),11) AS avgbid,
                round(AVG(ask),11) AS avgask,
                AVG(baseVolume) AS avgvolume
              FROM bh_tickers
              WHERE symbol = '$pair'
              AND UNIX_TIMESTAMP(`created_at`) > ($offset)
              GROUP BY bh_exchanges_id, buckettime 
              ORDER BY buckettime DESC
          "));
        }

        if ($returnRS) {
            $ret = $results;
        } else {
            $ret = $this->organizePairData($results, $limit);
        }

        \Cache::put($key, $ret, 2);
        return $ret;
    }
}
