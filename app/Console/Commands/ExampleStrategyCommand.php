<?php

namespace Bowhead\Console\Commands;

use Bowhead\Traits\OHLC;
use Bowhead\Util;
use Illuminate\Console\Command;
// https://github.com/andreas-glaser/poloniex-php-client

/**
 * Class ExampleCommand.
 */
class ExampleStrategyCommand extends Command
{
    use OHLC;

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

        $instruments = ['BTC/USD'];
        $util = new Util\BrokersUtil();
        $wc = new Util\Whaleclub($this->instrument);
        $console = new \Bowhead\Util\Console();
        $indicators = new \Bowhead\Util\Indicators();

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
                $underbought = $overbought = 0;
                $recentData = $this->getRecentData($instrument);

                $cci = $indicators->cci($instrument, $recentData);
                $cmo = $indicators->cmo($instrument, $recentData);
                $mfi = $indicators->mfi($instrument, $recentData);

                /* instrument is overbought, we will short */
                if ($cci == -1 && $cmo == -1 && $mfi == -1) {
                    $overbought = 1;
                }
                /* It is underbought, we will go LONG */
                if ($cci == 1 && $cmo == 1 && $mfi == 1) {
                    $underbought = 1;
                }

                /**
                 *   THIS SECTION IS FOR DISPLAY.
                 */
                $line = $console->colorize(" Signals for $instrument:");
                $line .= $console->colorize(str_pad("cci:$cci", 11), $this->doColor($cci));
                $line .= $console->colorize(str_pad("cmo:$cmo", 9), $this->doColor($cmo));
                $line .= $console->colorize(str_pad("mfi:$mfi", 9), $this->doColor($mfi));
                $line .= ($overbought ? $console->colorize(' overbought', 'light_red') : $console->colorize(' overbought', 'dark'));
                $line .= ($underbought ? $console->colorize(' underbought', 'light_green') : $console->colorize(' underbought', 'dark'));
                echo "$line";
                /*
                 *  DISPLAY DONE
                 */

                if ($overbought) {
                    $console->buzzer();
                    $current_price = array_pop($recentData['close']);
                    $order = [
                        'direction' => 'short', 'market' => 'BTC/USD', 'leverage' => 20, 'stop_loss' => $current_price + 50, 'take_profit' => $current_price - 100, 'size' => 0.1,
                    ];
                    $position = $wc->positionNew($order);
                    $console->colorize("\nOPENED NEW SHORT POSIITION");
                    print_r($position);
                }
                if ($underbought) {
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
            sleep(8);
        }
    }
}
