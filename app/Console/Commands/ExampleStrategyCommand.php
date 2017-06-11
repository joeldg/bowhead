<?php
/**
 *  ORCA cmd
 */
namespace Bowhead\Console\Commands;

use Bowhead\Console\Kernel;
use Illuminate\Console\Command;
use Bowhead\Strategy;
use Bowhead\Util;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use AndreasGlaser\PPC\PPC; // https://github.com/andreas-glaser/poloniex-php-client

/**
 * Class TurboCommand
 * @package Bowhead\Console\Commands
 */
class ExampleCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'bowhead:example_strategy';

    /**
     * @var string
     */
    protected $instrument = 'BTC-USD';

    /**
     * @var
     */
    protected $orca;

    /**
     * @var
     */
    protected $positions;

    /**
     * @var
     */
    protected $positions_time;

    /**
     * @var
     * positions attached to a indicator
     */
    protected $indicator_positions;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Binary options strategy bot';

    protected $order_cooloff;

    /**
     * @return null
     */
    public function buzzer()
    {
        echo "\x07";
        echo "\x07";
        echo "\x07";
        return null;
    }

    /**
     * @return int
     */
    public function shutdown()
    {
        if (!is_array($this->indicator_positions)){
            return 0;
        }
        foreach($this->indicator_positions as $key => $val) {
            echo "closing $key - $val\n";
            $this->orca->positionClose($val);
        }
        return 0;
    }

    public function doColor($val)
    {
        if ($val == 0){ return 'none'; }
        if ($val == 1){ return 'green'; }
        if ($val == -1){ return 'magenta'; }
        return 'none';
    }

    public function updateDb()
    {
        $ids = \DB::table('orca_turbo')->select(DB::raw('turbo_id,pair'))->whereNull('return')->get();;
        if (!empty($ids)) {
            foreach ($ids as $id) {
                echo "\nUPDATING " . $id->turbo_id;
                $order = $this->orca->turboGetPosition($id->turbo_id);
                $err = $order['body']['error'] ?? null;
                if ($err) {
                    \DB::table('orca_turbo')->where('turbo_id', $id->turbo_id)->update(['return'=>'0']);
                    return;
                }
                $prof = $order['profit'] ?? null;
                if ($prof) {
                    \DB::table('orca_turbo')->where('turbo_id', $id->turbo_id)->update(['return' => $prof]);
                }
            }
        }
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        echo "PRESS 'q' TO QUIT AND CLOSE ALL POSITIONS\n\n\n";
        stream_set_blocking(STDIN, 0);

        $instruments = ['USD_JPY','NZD_USD','EUR_GBP','USD_CAD','USD_CNH','USD_MXN','USD_TRY','AUD_USD','EUR_USD','USD_CHF'];
        $util = new \Bowhead\Util\Util();
        $console = new \Bowhead\Util\Console();
        $indicators = new \Bowhead\Util\Indicators();
        $candles = new \Bowhead\Util\Candles();
        #echo $util->getCurr();

        $recents = [];
        foreach($instruments as $instrument) {
            $recents['stoch'][$instrument] = 0;
        }

        $this->orca = $orca = new Strategy\orcaStrategy($this->instrument);
        register_shutdown_function(array($this, 'shutdown'));

        /**
         *  TURBO TURBO TURBO TURBO TURBO TURBO TURBO TURBO TURBO TURBO TURBO TURBO
         *
         *  STRATEGY 1:
         *  This stochf Forex 'Trending' strategy is summarized up as:
         *  call/buy When Stoch (1) crosses lower 10% and SAR is below a green candle (1).
         *  put/sell When Stoch (-1) crosses upper 10% and SAR is above a red candle (-1)
         *  This will rarely hit.
         *
         *  STRATEGY 2:
         *  Awesome Oscillator + MACD strategy here that will hit more
         *  often, though still fairly rare.
         *  The idea is when the MACD goes negative and AO does a bearish crossing we can short
         *  and when the MACD is positive and AO does a bullish crossing we can buy.
         *
         *  STRATEGY 3:
         *  ADX(14), SMA(40) and SMA(6)
         *  Long when adx +1 and 6-ema crosses 40-sma
         *  Short when adx -1 and 40-sma crosses 6ema
         */

        while(1) {
            $sec = date('s');
            if ($sec == 11 || $sec == 12) {
                $this->updateDb();
            }
            if (ord(fgetc(STDIN)) == 113) {
                echo "QUIT detected...";
                return null;
            }

            echo "\n";
            foreach($instruments as $instrument) {
                $wc_instrument = str_replace('_','-', $instrument);
                #$cand = $candles->allCandles($instrument, $recentData);

                $recentData = $this->getRecentData($instrument);

                // strategy 1 - SAR+Stoch
                $fsar   = $indicators->fsar($instrument, $recentData);
                $stoch  = $indicators->stoch($instrument, $recentData);
                $stochf = $indicators->stochf($instrument, $recentData);

                // strategy 2 - AO+MACD
                $ao     = $indicators->awesome_oscillator($instrument, $recentData);
                $macd   = $indicators->macd($instrument, $recentData);

                // strategy 3 - ADX(14)+SMA(6)+SMA(40)
                $adx         = $indicators->adx($instrument, $recentData);
                $_sma6       = trader_sma($recentData['close'], 6);
                $sma6        = array_pop($_sma6);
                $prior_sma6  = array_pop($_sma6);
                $_sma40      = trader_sma($recentData['close'], 40);
                $sma40       = array_pop($_sma40);
                $prior_sma40 = array_pop($_sma40);
                /** have the lines crossed? */
                // https://www.tradingview.com/x/kH5sdnHR/
                $sixCross   = (($prior_sma6 < $sma40 && $sma6 > $sma40) ? 1 : 0);
                $fortyCross = (($prior_sma40 < $sma6 && $sma40 > $sma6) ? 1 : 0);

                $line = $console->colorize(" Examine $instrument:");
                $line .= $console->colorize(str_pad("special:$fsar",11), $this->doColor($fsar));
                $line .= $console->colorize(str_pad("stoch:$stoch",9), $this->doColor($stoch));
                $line .= str_pad("fast_stoch:$stochf",14);
                $line .= str_pad("AO:$ao", 8);
                $line .= str_pad("macd:$macd", 7);
                $line .= str_pad("ADX:$adx", 6);
                $line .= ($sixCross   ? $console->colorize(' sixCross', 'light_green') : $console->colorize(' sixCross', 'dark'));
                $line .= ($fortyCross ? $console->colorize(' fortyCross', 'light_red') : $console->colorize(' fortyCross', 'dark'));
                echo "$line";



                /** this is sell turbo */
                if (($fsar == -1 && ($stoch == -1 || $stochf == -1)) || ($macd == -1 && $ao == -100) || ($adx == 1 && $sixCross == 1) ) {
                    if (\Cache::has("wc::turbo::$wc_instrument")) {
                    } else {
                        $strategy = ($fsar == -1 && ($stoch == -1 || $stochf == -1)  ? 'sar_stoch' : '');
                        $strategy = (($macd == -1 && $ao == -100) ? 'macd_ao' : $strategy);
                        $strategy = (($adx == -1 && $fortyCross) ? 'adx_sma' : $strategy);

                        $this->buzzer();
                        $line = ">>>>>>>>>>>>>> Found a sell $instrument";
                        echo "\n" . $console->colorize($line, 'red');
                        $order = $this->orca->turboNew('short', $wc_instrument, ($strategy == 'UNK' ? '5min' : '1min'));
                        \Cache::put("wc::turbo::$wc_instrument", 1, 61); // at least one minute
                        $err = $order['error'] ?? null;
                        if ($err) {
                            continue;
                        }

                        $turb['turbo_id']  = $order['body']['id'];
                        $turb['pair']      = "$wc_instrument";
                        $turb['direction'] = "short";
                        $turb['strategy']  = "$strategy";
                        \DB::table('orca_turbo')->insert($turb);
                    };
                }
                /** this is a buy turbo */
                if (($fsar == 1 && ($stoch == 1 || $stochf == 1)) || ($macd == 1 && $ao == 100) || ($adx == -1 && $fortyCross == 1)) {
                    if (\Cache::has("wc::turbo::$wc_instrument")) {
                    } else {
                        $strategy = ($fsar == 1 && ($stoch == 1 || $stochf == 1)  ? 'sar_stoch' : '');
                        $strategy = (($macd == 1 && $ao == 100) ? 'macd_ao' : $strategy);
                        $strategy = (($adx == 1 && $sixCross) ? 'adx_sma' : $strategy);

                        $this->buzzer();
                        $line = "<<<<<<<<<<<<<< Found a buy $instrument";
                        echo "\n" . $console->colorize($line, 'green');
                        $order = $this->orca->turboNew('long', $wc_instrument, ($strategy == 'UNK' ? '5min' : '1min'));
                        \Cache::put("wc::turbo::$wc_instrument", 1, 61); // at least one minute
                        $err = $order['error'] ?? null;
                        if ($err) {
                            continue;
                        }

                        $turb['turbo_id']  = $order['body']['id'];
                        $turb['pair']      = "$wc_instrument";
                        $turb['direction'] = "long";
                        $turb['strategy']  = "$strategy";
                        \DB::table('orca_turbo')->insert($turb);
                    }
                }

                #$recents['stoch'][$instrument][] = $stoch;
                #if (count($recents['stoch'][$instrument]) > 12) {
                #    array_shift($recents['stoch'][$instrument]);
                #}
            }

           sleep(1);
        }
    }

    /**
     * @param $datas
     *
     * @return array
     */
    private function organizePairData($datas, $norev=false)
    {
        $ret = array();
        foreach ($datas as $data) {
            $ret['date'][]   = $data->ts ?? null;
            $ret['low'][]    = $data->low ?? null;
            $ret['high'][]   = $data->high ?? null;
            $ret['open'][]   = $data->open ?? null;
            $ret['close'][]  = $data->close ?? null;
            $ret['volume'][] = $data->volume ?? null;
        }
        if ($norev) {
            return $ret;
        }
        foreach($ret as $key => $rettemmp) {
            $ret[$key] = array_reverse($rettemmp);
        }
        return $ret;
    }

    /**
     * @param string $pair
     * @param int    $limit
     * @param bool   $returnRS
     *
     * @return array
     */
    private function getRecentData($pair='BTC/USD', $limit=120, $returnRS=false)
    {
        /**
         *  we need to cache this as many strategies will be
         *  doing identical pulls for signals.
         */
        $timeid = date('YmdHi');
        $key = 'recent::' . $pair . '::' . $limit . "::$returnRS";
        if (\Cache::has($key)) {
            return \Cache::get($key);
        }

        $a = \DB::table('orca_bitfinex_ohlc')
            ->select(DB::raw('*, timeid as ts, HOUR(ctime) AS buckethour'))
            ->where('instrument', $pair)
            #->where('timeid', '<>', $timeid)
            ->orderby('timeid', 'DESC')
            ->limit($limit)
            ->get();
        if ($returnRS) {
            $ret = $a;
        } else {
            if (!empty($a)) {
                $ret = $this->organizePairData($a, false);
            } else {
                return [];
            }
        }

        \Cache::put($key, $ret, 5); // cache for 5 seconds
        return $ret;
    }
}
