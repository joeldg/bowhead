<?php

namespace Bowhead\Console\Commands;

use Bowhead\Traits\OHLC;
use Bowhead\Util;
use Illuminate\Console\Command;
// https://github.com/andreas-glaser/poloniex-php-client

/**
 * Class ExampleForexCommand.
 */
class ExampleForexStrategyCommand extends Command
{
    use OHLC;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'bowhead:example_forex_strategy';

    /**
     * @var string
     */
    protected $instrument = 'BTC-USD';

    /**
     * @var
     */
    protected $wc;

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
     * @return int
     */
    public function shutdown()
    {
        if (!is_array($this->indicator_positions)) {
            return 0;
        }
        foreach ($this->indicator_positions as $key => $val) {
            echo "closing $key - $val\n";
            $this->wc->positionClose($val);
        }

        return 0;
    }

    public function doColor($val)
    {
        if ($val == 0) {
            return 'none';
        }
        if ($val == 1) {
            return 'green';
        }
        if ($val == -1) {
            return 'magenta';
        }

        return 'none';
    }

    /**
     * @return null
     *
     *  this is the part of the command that executes.
     */
    public function handle()
    {
        echo "PRESS 'q' TO QUIT AND CLOSE ALL POSITIONS\n\n\n";
        stream_set_blocking(STDIN, 0);

        $instruments = ['USD_JPY', 'NZD_USD', 'EUR_GBP', 'USD_CAD', 'USD_CNH', 'USD_MXN', 'USD_TRY', 'AUD_USD', 'EUR_USD', 'USD_CHF'];
        $util = new Util\BrokersUtil();
        $wc = new Util\Whaleclub($this->instrument);
        $console = new Util\Console();
        $indicators = new Util\Indicators();

        $this->wc = $wc;
        register_shutdown_function([$this, 'shutdown']);  //

        /*
         *  Enter a loop where we check the strategy every minute.
         */
        while (1) {
            if (ord(fgetc(STDIN)) == 113) { // try to catch keypress 'q'
                echo 'QUIT detected...';

                return;
            }
            echo "\n";

            foreach ($instruments as $instrument) {
                $buy = $sell = 0;
                $recentData = $this->getRecentData($instrument);
                $adx = $indicators->adx($instrument, $recentData);
                $_sma6 = trader_sma($recentData['close'], 6);
                $sma6 = @array_pop($_sma6);
                $prior_sma6 = @array_pop($_sma6);
                $_sma40 = trader_sma($recentData['close'], 40);
                $sma40 = @array_pop($_sma40);
                $prior_sma40 = @array_pop($_sma40);
                /** have the lines crossed? */
                $down_cross = (($prior_sma6 <= $prior_sma40 && $sma6 > $sma40) ? 1 : 0); // 40 dips below 6
                $up_cross = (($prior_sma40 <= $prior_sma6 && $sma40 > $sma6) ? 1 : 0); // 40 jumps above 6

                if ($adx == 1 && $down_cross) {
                    $buy = 1;
                }
                if ($adx == 1 && $up_cross) {
                    $sell = 1;
                }

                /**
                 *   THIS SECTION IS FOR DISPLAY.
                 */
                $line = $console->colorize(" Signals for $instrument:");
                $line .= $console->colorize(str_pad("adx:$adx", 7), $this->doColor($adx));
                $line .= ($down_cross ? $console->colorize(' down_cross', 'light_red') : $console->colorize(' down_cross', 'dark'));
                $line .= ($up_cross ? $console->colorize(' up_cross', 'light_green') : $console->colorize(' up_cross', 'dark'));
                echo "\n$line";
                /*
                 *  DISPLAY DONE
                 */

                if ($sell) {
                    $console->buzzer();
                    $current_price = array_pop($recentData['close']);
                    $order = [
                        'direction' => 'short', 'market' => 'BTC/USD', 'leverage' => 20, 'stop_loss' => $current_price + 50, 'take_profit' => $current_price - 100, 'size' => 0.1,
                    ];
                    $position = $wc->positionNew($order);
                    $console->colorize("\nOPENED NEW SHORT POSIITION");
                    print_r($position);
                }
                if ($buy) {
                    $console->buzzer();
                    $current_price = array_pop($recentData['close']);
                    $order = [
                        'direction' => 'long', 'market' => 'BTC/USD', 'leverage' => 20, 'stop_loss' => $current_price - 50, 'take_profit' => $current_price + 100, 'size' => 0.1,
                    ];
                    $position = $wc->positionNew($order);
                    $console->colorize("\nOPENED NEW LONG POSIITION");
                    print_r($position);
                }
            }
            sleep(2);
        }
    }
}
