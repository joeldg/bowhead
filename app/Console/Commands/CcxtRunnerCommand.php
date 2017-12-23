<?php
/**
 * Created by PhpStorm.
 * User: joeldg
 * Date: 12/21/17
 * Time: 9:22 PM
 */
namespace Bowhead\Console\Commands;

use Bowhead\Models;
use Bowhead\Util\Console;
use Carbon\Carbon;
use ccxt\BaseError;
use ccxt\bitfinex;
use ccxt\gdax;
use Illuminate\Console\Command;
use ccxt\AuthenticationError;
use Bowhead\Traits\Config;

class CcxtRunnerCommand extends Command
{
    use Config;

    /**
     * @var array
     */
    protected $pairs = [];

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'bowhead:ccxt_runner';

    /**
     * @var string
     */
    protected $signature = 'bowhead:ccxt_runner {--update} {--v} {--vv}';

    /**
     * @var int
     */
    protected $memusage = 0;

    /**
     * @var int
     */
    protected $lastmemusage = 0;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'The Fx stream processor.';

    /**
     * @param $size
     *
     * @return string
     */
    function convert($size)
    {
        if ($size == 0) {
            return "0b";
        }
        $unit=array('b','kb','mb','gb','tb','pb');
        if ($size < 0) {
            return "-" . @round(abs($size)/pow(1024,($i=floor(log(abs($size),1024)))),2).' '.$unit[$i];
        }
        return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
    }

    /**
     * @param $line
     */
    public function profile($line)
    {
        gc_enable();
        $mem = memory_get_usage();
        $pri = $this->lastmemusage;
        $memchange = $mem-$pri;

        echo "$line mem: ". $this->convert($mem) ." used, ". $this->convert($memchange)." from ". $this->convert($pri) ."\n";
        $this->lastmemusage = $mem;

        return;
    }


    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        ini_set('memory_limit','256M');
        $console = new Console();
        stream_set_blocking(STDIN, 0);

        $update_all = $this->option('update');
        $verbose = $this->option('v');
        $very_verbose = $this->option('vv');

        if ($verbose){$this->profile(__LINE__);}

        $trading_pairs = $this->bowhead_config('trading_pairs');
        if (empty($trading_pairs)) {
            echo $console->colorize("
                You need to add in some trading pairs in the bh_configs table.
                This can be done by running the migrations and seeding the database.", 'bg_red', 'bold');
            echo "\n";
            die(1);
        }
        $trading_pairs = explode(',', $trading_pairs);

        /**
         *   USER PASSED IN --update TO REFRESH ALL THE EXCHANGES AND PAIRS
         *   ( this is not necessary to do very often )
         */
        if ($update_all) {
            /**
             *  First update the exchanges
             */
            $exchanges = \ccxt\Exchange::$exchanges;
            foreach ($exchanges as $exchange) {
                $classname = '\ccxt\\' . $exchange;
                $class = new $classname;

                $ins = [];
                $ins['exchange'] = $exchange;
                $ins['hasFetchTickers'] = $class->hasFetchTickers ?? 1;
                $ins['hasFetchOHLCV'] = $class->hasFetchOHLCV ?? 1;
                $ins['data'] = json_encode($class->markets_by_id,1);

                $exchange_model = new Models\bh_exchanges();
                $exchange_model::updateOrCreate(['exchange' => $exchange], $ins);
            }
            /**
             *  Update the list of pairs available to trade
             *  We skip ones with use=-1 as they are either broke or have issues.
             */
            $ex_loop = Models\bh_exchanges::where('use', '=>', 0)->get();
            foreach ($ex_loop as $ex) {
                $exid = $ex->id;
                $exchange = $ex->exchange;

                $classname = '\ccxt\\' . $exchange;
                $class = new $classname;
                try {
                    echo "updating $exchange data\n";
                    $markets = $class->load_markets();
                    foreach (array_keys($markets) as $pair) {
                        $pair_model = new Models\bh_exchange_pairs();
                        $pair_model::updateOrCreate(['exchange_id' => $exid, 'exchange_pair' => $pair]);
                    }
                    $markets = [];
                } catch (AuthenticationError $e) {
                    echo "\n\t$exchange needs auth (set this exchange to -1 in the database to disable it):\n $e..\n\n";
                } catch (BaseError $e) {
                    echo "\n\t$exchange error (set this exchange to -1 in the database to disable it):\n $e\n\n";
                }
            }
            echo "\n\nUPDATED .. run normally now\n\n";
            die();
        }

        /**
         *  Do class instantiation here to avoid doing it in the loop which
         *  adds to memory on each loop for the system try/catch
         */
        $ex_loop = Models\bh_exchanges::where('use', '>', 0)->get();
        foreach ($ex_loop as $ex) {
            $exid = $ex->id;
            $exchange = $ex->exchange;
            $classname = '\ccxt\\' . $exchange;
            ${'bh_'.$exchange} = new $classname(array (
                'enableRateLimit' => true,
            ));
            if ($verbose){echo "$exchange mem: ". $this->profile(__LINE__);}
        }
        $carbon = new Carbon();

        /**
         * enter loop with our preferred (use = 1)
         */
        while (1) {
            if ($verbose){$this->profile(__LINE__);}

            if (ord(fgetc(STDIN)) == 113) {
                echo "QUIT detected...";
                return null;
            }
            $ex_loop = Models\bh_exchanges::where('use', '>', 0)->get();
            foreach ($ex_loop as $ex) {
                $exid = $ex->id;
                $exchange = $ex->exchange;
                if (isset(${'bh_'.$exchange})) {
                    $class = ${'bh_' . $exchange};
                } else {
                    $classname = '\ccxt\\' . $exchange;
                    ${'bh_'.$exchange} = new $classname(array (
                        'enableRateLimit' => true,
                    ));
                    $class = ${'bh_' . $exchange};
                }

                try {
                    #$markets = $class->load_markets();
                    foreach ($trading_pairs as $pair) {
                        if ($ex->hasFetchTickers) {
                            $tick = $class->fetchTicker($pair);
                            unset($tick['info']);
                            $dt = explode('.', $tick['datetime']);
                            $tick['timestamp'] = (intval($tick['timestamp']) / 1000);
                            $tick['bh_exchanges_id'] = $exid;
                            $tick['datetime'] = $dt[0];
                            $tickers_model = new Models\bh_tickers();
                            $tickers_model::updateOrCreate(
                                ['bh_exchanges_id' => $exid, 'symbol' => $pair, 'timestamp' => $tick['timestamp']]
                                , $tick);
                        }
                        if ($ex->hasFetchOHLCV) {
                            $ohlcc = $class->fetchOHLCV($pair, '1m', ($carbon->now()->subMinutes(5)->timestamp*1000), 3);
                            $ohlc_model = new Models\bh_ohlcvs();
                            foreach($ohlcc as $oh){
                                $ins = [];
                                $ins['bh_exchanges_id'] = $exid;
                                $ins['symbol'] = $pair;
                                $ins['timestamp'] = (intval($oh[0])/1000);
                                $ins['datetime'] = $carbon->createFromTimestamp(($oh[0]/1000))->toDateTimeString();
                                $ins['open']   = $oh[1];
                                $ins['high']   = $oh[2];
                                $ins['low']    = $oh[3];
                                $ins['close']  = $oh[4];
                                $ins['volume'] = $oh[5];

                                $ohlc_model::updateOrCreate(
                                    ['bh_exchanges_id' => $exid, 'symbol' => $pair, 'timestamp' => $ins['timestamp']]
                                    , $ins);
                            }
                        }
                    }
                } catch (\Exception $e) {
                    if ($verbose){$this->profile(__LINE__);}
                    if($verbose) {
                        echo "temp issue with $exchange\n";
                        if ($very_verbose) {
                            echo $e;
                        }
                    }
                    unset($e); // or will cause mem leak
                } catch (AuthenticationError $e) {
                    echo "\n\t$exchange needs auth (set this exchange to -1 in the database to disable it):\n $e..\n\n";
                } catch (BaseError $e) {
                    echo "\n\t$exchange error (set this exchange to -1 in the database to disable it):\n $e\n\n";
                }//*/
            }
            if($verbose) {
                echo "line: " . __LINE__ . " mem: ". $this->convert(memory_get_usage()) ." used\n";
                echo "Sleeping\n";
            }
            sleep(5);
        }
    }
}
