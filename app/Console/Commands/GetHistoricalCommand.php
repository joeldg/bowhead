<?php
/**
 * Created by PhpStorm.
 * User: joeldg
 * Date: 4/12/17
 * Time: 4:20 PM
 */

namespace Bowhead\Console\Commands;

use Bowhead\Console\Kernel;
use Illuminate\Console\Command;
use DateInterval;
use DateTime;

class GetHistoricalCommand extends Command {
    /**
     * @var string
     */
    protected $name = 'bowhead:get_historical';

    /**
     * @var string
     */
    protected $description = 'Get hour data for all pairs in .env PAIRS and store in the Database for backtesting';

    /**
     *  do it..
     */
    public function fire()
    {
        $util = new \Bowhead\Util\Util();
        $console = new \Bowhead\Util\Console();
        $ledger = new \Bowhead\Util\Coinbase();

        #$data = $ledger->get_instruments();
        $pairs = explode(',', env('PAIRS'));

        $date_list = array();
        $day1 = '2017-04-18';
        $diff1Day = new DateInterval('P1D');
        $day = new DateTime('2017-05-01 00:00:00');
        while($day1 <= date('Y-m-d')) {
            $day1 = date("Y-m-d", $day->getTimestamp());
            $day->add($diff1Day);
            $date_list[$day1] = date("Y-m-d", $day->getTimestamp());
        }

        foreach ($pairs as $pair) {
            foreach ($date_list as $key => $val) {
                sleep(1); // otherwise will get rate limited
                echo "Doing $pair $key / $val\n";
                $linkpart = "?start=" . $key . "T00:00:00.000Z&&end=" . $val . "T00:00:00.000Z&&granularity=3600";
                $data = $util->get_endpoint('rates', null, $linkpart, $pair);
                #echo "got $pair: $key / $val\n";
                foreach ($data as $d) {
                    if (!is_array($d)) {
                        continue;
                    }
                    $insert = array(
                        'pair' => $pair,
                        'buckettime' => date('Y-m-d H;i:s', $d[0]),
                        'low' => $d[1],
                        'high' => $d[2],
                        'open' => $d[3],
                        'close' => $d[4],
                        'volume' => $d[5]
                    );
                    $count = \DB::table('historical')->select('*')
                        ->where('pair', $pair)
                        ->where('buckettime', date('Y-m-d H;i:s', $d[0]))
                        ->count();
                    if ($count < 1) {
                        \DB::table('historical')->insert($insert);
                    }
                }
            }
        }

    }
}