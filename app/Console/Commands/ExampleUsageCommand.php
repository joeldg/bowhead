<?php

namespace Bowhead\Console\Commands;

use AndreasGlaser\PPC\PPC;
use Bowhead\Strategy\Whaleclub;
use Bowhead\Util\Candles;
use Bowhead\Util\Coinbase;
use Bowhead\Util\Indicators;
use Bowhead\Util\Other;
use Bowhead\Util\OneBroker;
use Bowhead\Util\Console;
use Illuminate\Console\Command;

/**
 * Class ExampleUsageCommand
 * @package Bowhead\Console\Commands
 *
 *          This file is mostly to just verify that you have things working and have the
 *          keys for the API's in the right place.
 *
 *          If this file have errors, it should show you which one is in error..
 */
class ExampleUsageCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bowhead:example_usage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Examples of how to use the various libs here.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

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
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /** instantiate all the utils */
        $candles    = new Candles();
        $indicators = new Indicators();
        $math       = new Other(); // not really used
        $console    = new Console();

        /** instantiate all the brokerages */
        $whaleclub = new Whaleclub('BTC/USD');
        $onebroker = new OneBroker();
        $cointbase = new Coinbase();
        $poloniex  = new PPC(env('POLONIEX_API'), env('POLONIEX_SECRET'));

        $stop = false;

        if (!function_exists('trader_sma')) {
            echo $console->colorize("\nYou are missing the Trader extension http://php.net/manual/en/book.trader.php");
            echo $console->colorize("\n`curl -O http://pear.php.net/go-pear.phar`");
            echo $console->colorize("\n`sudo php -d detect_unicode=0 go-pear.phar`");
            echo $console->colorize("\n`sudo pecl install trader`");
            $stop = true;
        }
        if (empty(env('WHALECLUB_TOKEN'))) {
            echo $console->colorize("\nSignup on Whaleclub, use https://whaleclub.co/join/tn6uE for 30% deposit bonus.");
            $stop = true;
        }
        if (empty(env('ONEBROKER_TOKEN'))) {
            echo $console->colorize("\nSign up for a OneBroker account: https://1broker.com/?r=21434");
            $stop = true;
        }
        if (empty(env('CBKEY'))) {
            echo $console->colorize("\nSign up for a Coinbase/GDAX account: https://www.coinbase.com/join/51950ca286c21b84dd000021");
            $stop = true;
        }
        if (empty(env('BITFINIX_KEY'))) {
            echo $console->colorize("\nSign up for a Bitfinex account: https://www.bitfinex.com");
            $stop = true;
        }
        if (empty(env('OANDA_TOKEN'))) {
            echo $console->colorize("\nSign up for a Oanda account: https://www.oanda.com/");
            $stop = true;
        }
        if (empty(env('POLONIEX_API'))) {
            echo $console->colorize("\nSign up for a Poloniex account: https://poloniex.com");
            $stop = true;
        }

        if ($stop) {
            $this->buzzer();
            echo $console->colorize("\nYou will need to sign up for the above accounts to see the example.\n\n", "red");
            return null;
        }

        /**
         *  Lets load up some data
         */

        $account = $whaleclub->getBalance();
        echo $console->colorize("WhaleClub\n");
        echo $console->tableFormatArray(array_dot($account));

        $account = $onebroker->userDetailsGet();
        echo $console->colorize("1Broker\n");
        echo $console->tableFormatArray(array_dot($account));

        $account = $cointbase->getAccount();
        echo $console->colorize("GDAX\n");
        echo $console->tableFormatArray(array_dot($account));

        // This was not written by me, I am just using it..
        // SEE: https://github.com/andreas-glaser/poloniex-php-client
        $account = $poloniex->getDepositAddresses();
        echo $console->colorize("Poloniex\n");
        echo $console->tableFormatArray(array_dot($account->decoded));

        for ($i = 0; $i <= 150; $i++) {
            usleep(10000);
            $console ->progressBar($i, 150);
            if ($i == 150) {
                echo "\n";
            }
        }//*/
    }
}
