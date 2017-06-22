<?php

namespace Bowhead\Console\Commands;

use AndreasGlaser\PPC\PPC;
use Bowhead\Util\Whaleclub;
use Bowhead\Util\Bitfinex;
use Bowhead\Util\Candles;
use Bowhead\Util\Coinbase;
use Bowhead\Util\Indicators;
use Bowhead\Util\Oanda;
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
        $bitfinex  = new Bitfinex(env('BITFINIX_KEY'),env('BITFINIX_SECRET'));

        $stop = $warn = false;

        echo $console->colorize("\nSee the tutorial: \nhttps://medium.com/@joeldg/an-advanced-tutorial-a-new-crypto-currency-trading-bot-boilerplate-framework-e777733607a\n", 'yellow');

        if (!function_exists('trader_sma')) {
            echo $console->colorize("\nYou are missing the required Trader extension http://php.net/manual/en/book.trader.php",'reverse');
            echo $console->colorize("\n`TO INSTALL:");
            echo $console->colorize("\n`curl -O http://pear.php.net/go-pear.phar`");
            echo $console->colorize("\n`sudo php -d detect_unicode=0 go-pear.phar`");
            echo $console->colorize("\n`sudo pecl install trader`\n");
            $stop = true;
            return null;
        }
        if (empty(env('WHALECLUB_TOKEN'))) {
            echo $console->colorize("\nThis account type is required for the tutorial.",'reverse');
            echo $console->colorize("\nSignup on Whaleclub: Use https://whaleclub.co/join/tn6uE for 30% deposit bonus.\n\n",'yellow');
            $stop = true;
            return null;
        } else {
            $account = $whaleclub->getBalance();
            echo $console->colorize("WhaleClub\n");
            echo $console->tableFormatArray(array_dot($account));
        }

        if (empty(env('ONEBROKER_TOKEN'))) {
            echo $console->colorize("\nSign up for a OneBroker account: Use https://1broker.com/?r=21434 for bonus", 'yellow');
            $warn = true;
        } else {
            $account = $onebroker->userDetailsGet();
            echo $console->colorize("1Broker\n");
            echo $console->tableFormatArray(array_dot($account));
        }

        if (empty(env('CBKEY'))) {
            echo $console->colorize("\nSign up for a Coinbase/GDAX account: Use https://www.coinbase.com/join/51950ca286c21b84dd000021 for bonus",'yellow');
            $warn = true;
        } else {
            $account = $cointbase->getAccount();
            echo $console->colorize("GDAX\n");
            echo $console->tableFormatArray(array_dot($account));
        }

        if (empty(env('BITFINIX_KEY'))) {
            echo $console->colorize("\nSign up for a Bitfinex account: https://www.bitfinex.com",'red');
            $stop = true;
        } else {
            $account = $bitfinex->account_info();
            echo $console->colorize("Bitfinex\n");
            echo $console->tableFormatArray(array_dot($account));
        }

        if (empty(env('OANDA_TOKEN'))) {
            echo $console->colorize("\nSign up for a Oanda account: https://www.oanda.com/",'red');
            $stop = true;
        }
        if (empty(env('POLONIEX_API'))) {
            echo $console->colorize("\nSign up for a Poloniex account: https://poloniex.com", 'yellow');
            $warn = true;
        } else {
            // This was not written by me, I am just using it..
            // SEE: https://github.com/andreas-glaser/poloniex-php-client
            $account = $poloniex->getDepositAddresses();
            echo $console->colorize("Poloniex\n");
            echo $console->tableFormatArray(array_dot($account->decoded));
        }

        if ($stop) {
            $console->buzzer();
            echo $console->colorize("\nYou will need to sign up for the above accounts to use the example.\n\n", "red");
            return null;
        }
        if ($warn) {
            $console->buzzer();
            echo $console->colorize("\nMissing API keys, You will want to sign up for the accounts above.\n\n", "yellow");
        }


        for ($i = 0; $i <= 150; $i++) {
            usleep(10000);
            $console ->progressBar($i, 150);
            if ($i == 150) {
                echo "\n";
            }
        }//*/

        if($cand = $candles->allCandles()){
            echo $console->colorize("Candles on sample data\n");
            echo $console->tableFormatArray(array_dot($cand));
        } else {
            $console->buzzer();
            echo $console->colorize("\nCould not load candles, did you import the sample data?\n");
        }

        if($ind = $indicators->allSignals()){
            echo $console->colorize("Signals on sample data\n");
            echo $console->tableFormatArray(array_dot($ind));
        } else {
            echo $console->colorize("\nCould not load signals, did you import the sample data?\n");
        }

        echo $console->colorize("\nLooks good",'green');
        echo "\n";
    }
}
