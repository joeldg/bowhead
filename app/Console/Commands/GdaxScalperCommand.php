<?php
/**
 * Created by PhpStorm.
 * User: joeldg
 * Date: 4/7/17
 * Time: 9:12 PM
 */

namespace Bowhead\Console\Commands;

use Bowhead\Traits\OHLC;
use Bowhead\Traits\Signals;
use Bowhead\Traits\Strategies;
use Bowhead\Util\Console;
use Bowhead\Console\Kernel;
use Bowhead\Util;
use Illuminate\Console\Command;

/**
 * Class WebsocketCommand
 * @package App\Console\Commands
 *
 *          This console command is for doing a websocket to GDAX
 *          https://docs.gdax.com/?php#overview
 *
 *          To keep a real-time book of a instrument use level 3
 *          https://docs.gdax.com/?php#get-product-order-book
 *
 *          Then match this up with the proper sequence
 */
class GdaxScalperCommand extends Command
{
    use OHLC, Strategies;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'bowhead:gdax_scalper';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Handle the GDAX websocket and display realitime data in the terminal';

    /**
     * @var currency pairs
     */
    protected $instrument = 'BTC-USD';

    /**
     * @var
     */
    protected $console;

    /**
     * @var
     */
    protected $coinbase;

    /**
     * @var current book
     */
    public $book;

    /**
     * @var
     */
    protected $orders;

    /**
     * @var
     */
    protected $bid;

    /**
     * @var
     */
    protected $ask;

    /**
     * @var
     */
    protected $bidsize;

    /**
     * @var
     */
    protected $asksize;

    /**
     * @var
     */
    protected $balances;

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $this->coinbase   = new Util\Coinbase();
        $this->console    = new Console();

        echo $this->console->colorize("------------------------------------------------------------------\n");
        echo $this->console->colorize("Set CBURL to api-public.sandbox.gdax.com before running this..\n");
        echo $this->console->colorize("This will trade live otherwise, so be CAREFUL\n");
        echo $this->console->colorize("PRESS ENTER TO CONTINUE\n");
        echo $this->console->colorize("------------------------------------------------------------------\n");

        $handle = fopen ("php://stdin","r");
        $line = fgets($handle);


        echo $this->console->colorize("UPDATING RECENT Open, High, Low, Close data\n");
        $_trades = $this->coinbase->get_endpoint('trades',null,null,'BTC-USD');
        $totalsize = $trades = [];
        $total = count($_trades);
        $i = 1;
        foreach($_trades as $tr) {
            $dates = date_parse($tr['time']);
            $timeid = $dates['year'].str_pad($dates['month'],2,0,STR_PAD_LEFT).str_pad($dates['day'],2,0,STR_PAD_LEFT).str_pad($dates['hour'],2,0,STR_PAD_LEFT).str_pad($dates['minute'],2,0,STR_PAD_LEFT);

            $totalsize[$timeid] = $totalsize[$timeid] ?? 0; // init if not present
            $totalsize[$timeid] += $tr['size'] ?? 0;        // otherwise increment
            $ticker = [];
            $ticker['timeid'] = $timeid;
            $ticker[7] = $tr['price'];
            $ticker[8] = $totalsize[$timeid] ?? 0;
            $this->markOHLC($ticker, 1, $this->instrument);
            $this->console->progressBar($i, $total);
            $i++;
        }
        echo $this->console->colorize("\nUPDATED $this->instrument\n");
        $this->update_state(); // init

        /**
         *  register_tick_function is way to call a class method every so often
         *  automatically so we don't have to keep a timer running and check if we
         *  need to update our data.
         */
        declare(ticks=60); // we have a sleep in our loop below also
        register_tick_function(array(&$this, 'update_state'), true);

        /**
         *  Our main loop
         */
        while (1){
            $_ticker = $this->coinbase->get_endpoint('ticker',null,null,'BTC-USD');
            $_orders = [];
            if (count($this->orders) > 0) {
                echo $this->console->colorize("\nCurrent orders:\n");
                foreach ($this->orders as $this_orders) {
                    $orders = [];
                    $orders['id']    = $this_orders['id'];
                    $orders['side']  = $this_orders['side'];
                    $orders['price'] = $this_orders['price'];
                    $orders['size']  = $this_orders['size'];
                    $orders['time_in_force'] = $this_orders['time_in_force'];
                    $_orders[] = $orders;
                    echo $this->console->tableFormatArray($orders, null, 'unicode');
                }
            }

            $ticker = [];
            $ticker[7] = $_ticker['price'];
            $ticker[8] = $_ticker['volume'];
            $this->markOHLC($ticker, 1, $this->instrument);
            $data = $this->getRecentData($this->instrument, 150);

            $sar_stoch_sig = $this->bowhead_sar_stoch($this->instrument, $data);
            /**
             *  If SAR is under a GREEN candle and STOCH crosses the lower line going up.
             *  Lets try to catch a dip before the upswing.
             *
             *  TODO: we need to add in tests for if we have the $ and/or if we have the BTC
             */
            if ($sar_stoch_sig > 1) {
                echo $this->console->colorize("Limit BUY with bowhead_sar_stoch\n");
                $price_move = $_ticker['price'] - 0.75;
                $this->coinbase->limit_buy($this->instrument, '0.01000000', $price_move, 'GTT', 'min');
            }

            /** if the opposite, then try to scalp in the other direction */
            if ($sar_stoch_sig > -1) {
                echo $this->console->colorize("Limit SELL with bowhead_sar_stoch\n");
                $price_move = $_ticker['price'] + 0.75;
                $this->coinbase->limit_sell($this->instrument, 0.01000000, $price_move, 'GTT', 'min');
            }

            /**
             *   TODO: continue with other strategies.
             *   TODO: keep stats and keep track of orders in the database.
             */


            sleep(5);
        }
    }

    private function update_state()
    {
        echo $this->console->colorize("Updating...\n", 'reverse');
        $this->orders = $this->coinbase->listorders();

        $this->book = $this->coinbase->get_endpoint('book',null,null,'BTC-USD');
        $this->bid = $this->book['bids'][0][0];
        $this->ask = $this->book['asks'][0][0];
        $this->bidsize = $this->book['bids'][0][1];
        $this->asksize = $this->book['asks'][0][1];

        $bals = $this->coinbase->get_balances();
        foreach($bals as $key => $bal) {
            $this->balances[$key] = $bal['available'];
        }
    }

    /**
     * @return mixed
     */
    private function getBook($instrument)
    {
        return $this->coinbase->get_endpoint('book', null, '?level=2', $instrument);
    }

}