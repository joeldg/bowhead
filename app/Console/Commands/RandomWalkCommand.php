<?php
namespace Bowhead\Console\Commands;

use Bowhead\Console\Kernel;
use Bowhead\Traits\CandleMap;
use Bowhead\Traits\OHLC;
use Bowhead\Traits\Pivots;
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
 *
 *          SEE COMMENTS AT THE BOTTOM TO SEE WHERE TO ADD YOUR OWN
 *          CONDITIONS FOR A TEST.
 *
 */
class RandomWalkCommand extends Command {

    use Signals, Strategies, CandleMap, OHLC, Pivots; // add our traits

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'bowhead:random_walk';

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

        $fibs = $this->calcFibonacci([]); // defaults to 'BTC/USD';
        $amt_takeprofit = $fibs['R3']+15;
        $amt_stoploss   = $fibs['S2']-10;

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
        $console     = new \Bowhead\Util\Console();
        $ind         = new Util\Indicators();
        $cand        = new Util\Candles();

        echo $console->colorize("------------------------------------------------------------------\n");
        echo $console->colorize("MAKE SURE YOU ARE IN DEMO MODE.\n");
        echo $console->colorize("This will trade live otherwise, so be CAREFUL\n");
        echo $console->colorize("PRESS ENTER TO CONTINUE\n");
        echo $console->colorize("------------------------------------------------------------------\n");

        $handle = fopen ("php://stdin","r");
        $line = fgets($handle);

        echo "PRESS 'q' TO QUIT AND CLOSE ALL POSITIONS\n\n\n";
        stream_set_blocking(STDIN, 0);

        $instruments = ['BTC/USD'];
        $leverages   = [222,200,100,88,50,25,1];
        /**
         *  $strategies = $this->strategies_all = every single strategy.
         *  $strategies = $this->strategies_1m  = only 1 minute periods
         *  $strategies = $this->strategies_5m  = only 5 minute periods
         *  $strategies = $this->strategies_15m = fifteen minute periods
         *  $strategies = $this->strategies_30m = thirty
         *  $strategies = $this->strategies_1h  = sixty
         */
        $strategies = $this->strategies_all;
        foreach($strategies as $k => $strategy) {
            $strategies[$k] = str_replace('bowhead_','',$strategy);
        }

        $list_indicators = array('adx','aroonosc','cmo','sar','cci','mfi','obv','stoch','rsi','macd','bollingerBands','atr','er','hli','ultosc','willr','roc','stochrsi');
        $list_signals    = ['rsi','stoch','stochrsi','macd','adx','willr','cci','atr','hli','ultosc','roc','er'];


        while(1) {
            if (ord(fgetc(STDIN)) == 113) { // try to catch keypress 'q'
                echo "QUIT detected...";
                return null;
            }
            // need our ohlc data
            $data        = $this->getRecentData('BTC/USD', 200);

            // candles
            $candles = $cand->allCandles('BTC/USD', $data);
            $candles = $candles['current'];

            // signals
            $signals = $this->signals(1, 0, ['BTC/USD']);

            // trends
            foreach($instruments as $instrument) {
                $trends[$instrument]['httc'] = $ind->httc($instrument, $data);      # Hilbert Transform - Trend vs Cycle Mode
                $trends[$instrument]['htl']  = $ind->htl($instrument, $data);       # Hilbert Transform - Instantaneous Trendline
                $trends[$instrument]['hts']  = $ind->hts($instrument, $data, true); # Hilbert Transform - Sinewave
                $trends[$instrument]['mmi']  = $ind->mmi($instrument, $data);       # market meanness
            }

            // our indicators
            $indicators = $ind->allSignals('BTC/USD', $data);
            unset($indicators['ma']); // not needed here.

            foreach ($indicators as $indicator_name => $indicator_value) {
                foreach ($signals['BTC/USD'] as $signal_name => $signal_value) {
                    foreach($candles as $candle_name => $candle_value) {
                        if ($signal_name == $indicator_name) {
                            continue;
                        }
                        $strategy_name = "$indicator_name". "_$signal_name" . "_$candle_name";
                        if ($candle_value > 0 && $signal_value > 0 && $indicator_value > 0) {
                            echo $console->colorize("CREATING A LONG ORDER: $strategy_name\n", 'green');
                            // do a buy here.
                            $this->createPosition('BTC-USD', 'long', $strategy_name, 0, 0, 0.1, 10);
                        }
                        if ($candle_value < 0 && $signal_value < 0 && $indicator_value < 0) {
                            echo $console->colorize("CREATING A SHORT ORDER: $strategy_name\n", 'red');
                            // do a short here.
                            $this->createPosition('BTC-USD', 'short', $strategy_name, 0, 0, 0.1, 10);
                        }
                    }
                }
            }

            $this->updateDb();
            echo "\nZzzz for one minute..";
            sleep(60);
        }

        return null;
    }


}
