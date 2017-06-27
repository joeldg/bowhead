<?php
namespace Bowhead\Console\Commands;

use Bowhead\Console\Kernel;
use Bowhead\Traits\Signals;
use Bowhead\Traits\Strategies;
use Illuminate\Console\Command;
use Bowhead\Util;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use AndreasGlaser\PPC\PPC;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class ExampleCommand
 * @package Bowhead\Console\Commands
 */
class TestStrategiesCommand extends Command {

    use Signals, Strategies; // add our traits

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'bowhead:test_strategies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Testing out the strategies we have.';


    /**
     * @param $val
     *
     * @return string
     */
    public function doColor($val)
    {
        if ($val == 0){ return 'none'; }
        if ($val == 1){ return 'green'; }
        if ($val == -1){ return 'magenta'; }
        return 'none';
    }

    /**
     * @param      $arr
     * @param bool $retarr
     *
     * @return array|string
     */
    public function compileSignals($arr, $retarr=false)
    {
        $console = new Util\Console();
        $pos = $neg = 0;
        foreach ($arr as $a) {
            $pos += ($a > 0 ? 1 : 0);
            $neg += ($a < 0 ? 1 : 0);
        }
        #$pos = $console->colorize($pos,'green');
        #$neg = $console->colorize($neg,'red');

        if ($retarr) {
            return ['pos'=>$pos, 'neg' => $neg];
        }
        return "$pos/-$neg";
    }

    /**
     *  updateDb
     */
    public function updateDb()
    {
        $wc = new Util\Whaleclub();
        $ids = \DB::table('bowhead_strategy')->select(DB::raw('unix_timestamp(ctime) AS stime, position_id, pair'))->whereNull('profit')->get();;
        if (!empty($ids)) {
            foreach ($ids as $id) {
                $modify = 301;
                if ($id->stime + $modify < time()) {
                    echo "\nUPDATING " . $id->position_id;
                    $order = $wc->positionGet($id->position_id);
                    $err = $order['body']['error'] ?? null;
                    if ($err) {
                        print_r($order);
                        #\DB::table('bowhead_strategy')->where('position_id', $id->position_id)->update(['profit' => '0', 'state' => 'error', 'close_reason' => 'error']);
                        return;
                    }
                    $prof = $order['profit'] ?? null;
                    if (!is_null($prof)) {
                        \DB::table('bowhead_strategy')->where('position_id', $id->position_id)->update(['profit' => $prof, 'state' => $order['state'], 'close_reason' => $order['close_reason']]);
                    }
                }
            }
        }
    }

    /**
     * @return array
     */
    public function getArguments()
    {
        return [
            ['runtest', InputArgument::OPTIONAL, 'Run DEMO tests?'],
        ];
    }

    /**
     * @param     $instrument
     * @param     $direction
     * @param     $strategy
     * @param int $pos
     * @param int $neg
     * @param int $size
     * @param int $lev
     *
     * @return array|bool
     */
    public function createPosition($instrument, $direction, $strategy, $pos=0, $neg=0, $size=2, $lev=200)
    {
        $cache_key = "wc::demo::$instrument:$direction:$strategy";
        if (\Cache::has($cache_key)) {
            return false;
        }

        $wc = new Util\Whaleclub();
        $price = $wc->getPrice(str_replace('_','-',$instrument));
        $price = $price['price'];

        /**
         *  These are just example stop loss and take profit amounts.
         *  We are just gonna let these ride and see what happens.
         *
         *  Example of EUR/GBP 200 leverage percentage:
         *   (price*(( % /leverage)/100)) = amount that is %
         *  (0.87881*(30/200))/100 = 0.00131821500000000000
         *
         *  30% of price with 200 leverage = ((30/200)/100) = 0.15%
         *
         */
        $tp = round(( $price * (30/$lev) ) / 100, 5);
        $sl = round(( $price * (20/$lev) ) / 100, 5);
        $amt_takeprofit = ($direction == 'long' ? ((float)$price + $tp) : ((float)$price - $tp));
        $amt_stoploss   = ($direction == 'long' ? ((float)$price - $sl) : ((float)$price + $sl));

        $order = [
             'direction'   => $direction
            ,'leverage'    => $lev
            ,'market'      => str_replace('_','-',$instrument)
            ,'take_profit' => $amt_takeprofit
            ,'stop_loss'   => $amt_stoploss
            ,'entry_price' => $entry ?? null
            ,'size'        => $size
        ];
        $info =  $wc->positionNew($order);
        print_r($info);
        $err = $info['error']['code'] ?? null;
        if (isset($info['error']) && is_array($info['error'])){
            return ['error' => $err];
        }
        $insert['position_id'] = $info['id'];
        $insert['pair']        = "$instrument";
        $insert['direction']   = "$direction";
        $insert['signalpos']   = $pos;
        $insert['signalneg']   = $neg;
        $insert['strategy']    = "$strategy";
        $insert['state']       = 'active';
        \DB::table('bowhead_strategy')->insert($insert);

        \Cache::put($cache_key, 1, 301); // at least five minutes

        return true;
    }

    /** -------------------------------------------------------------------
     * @return null
     *
     *  this is the part of the command that executes.
     *  -------------------------------------------------------------------
     */
    public function handle()
    {
        $rundemo     = false;
        $symbollines = $recentprices = [];
        if ($rundemo = $this->argument('runtest')) {
            $this->info("Running the DEMO test of all the strategies:");
        }

        echo "PRESS 'q' TO QUIT AND CLOSE ALL POSITIONS\n\n\n";
        stream_set_blocking(STDIN, 0);

        $console     = new \Bowhead\Util\Console();

        $instruments = ['USD_JPY','NZD_USD','EUR_GBP','USD_CAD','USD_CNH','USD_MXN','USD_TRY','AUD_USD','EUR_USD','USD_CHF'];
        $strategies = $this->strategies_all;
        foreach($strategies as $k => $strategy) {
            $strategies[$k] = str_replace('bowhead_','',$strategy);
        }

        while(1) {
            if (ord(fgetc(STDIN)) == 113) { // try to catch keypress 'q'
                echo "QUIT detected...";
                return null;
            }
            $recentprices = [];

            /**
             *  GET ALL OUR SIGNALS HERE
             */
            $signals = $this->signals(1); // get the full list

            /**
             *  First up we loop through the strategies dynamically run the strategies
             *  using $this->${'strategy'}(param1, param2)
             *  $symbollines just has [pair][strategy] = {-1/1/0}
             */
            foreach($instruments as $instrument) {
                $recentData = $this->getRecentData($instrument, 220);
                $recentData_copy = $recentData['close'];
                $recentprices[$instrument] = array_pop($recentData_copy);
                $flags = [];
                /**
                 *  Using $strategies_all from strategies trait
                 */
                foreach ($this->strategies_all as $strategy) {
                    $flags[str_replace('bowhead_','',$strategy)] = $this->${'strategy'}($instrument, $recentData);
                }
                $symbollines[$instrument] = $flags;
            }

            /**
             *   If we want to just view what the strategies
             *   are currently returning in a colored table.
             */
            if (!$rundemo) {
                $lines = [];
                $lines['top'] = '';
                $output = '';
                foreach ($instruments as $instrument) {
                    $comp = $this->compileSignals($signals[$instrument]);
                    $lines['top'] .= str_pad($instrument . "[$comp]", 17);
                    foreach ($strategies as $strategy) {
                        if (!isset($lines[$strategy])) {
                            $lines[$strategy] = '';
                        }
                        $color = ($symbollines[$instrument][$strategy] > 0 ? 'bg_green' : ($symbollines[$instrument][$strategy] < 0 ? 'bg_red' : 'bg_black'));
                        $lines[$strategy] .= $console->colorize(str_pad($strategy, 17), $color);
                    }
                }
                echo "\n\n" . $console->colorize(@$lines['top']);
                foreach ($strategies as $strategy) {
                    echo "\n" . $lines[$strategy];
                }
            } else {
                /**
                 *  DO THE ACTUAL TEST...
                 */
                foreach ($symbollines as $pair => $strategies) {
                    $sigs = $this->compileSignals($signals[$pair], 1);
                    foreach ($strategies as $strategy => $flag) {
                        if ($flag == 0){
                            continue; // not a short or a long
                        }
                        /**
                         *   TODO: HERE IS WHERE YOU CAN TEST SIGNALS BEFORE YOU CREATE
                         *   TODO: POSITIONS AND SEND THEM OUT.
                         *   TODO: YOU CAN REFINE YOUR STRATEGIES HERE FURTHER.
                         *   TODO: THIS IS REALLY JUST A SIMPLE AND EASY STARTING OFF
                         *   TODO: POINT FOR YOU.
                         */
                        $dir    = ($symbollines[$pair][$strategy] > 0 ? 'long' : 'short');
                        echo "\nCreate $dir for $pair $strategy";
                        $this->createPosition($pair, $dir, $strategy, $sigs['pos'], $sigs['neg']);
                    }
                }
            }
            $this->updateDb();
            echo "\nZzzz..";
            sleep(60);
        }

        return null;
    }


}
