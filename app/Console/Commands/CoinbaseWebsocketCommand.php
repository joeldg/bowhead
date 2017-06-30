<?php
/**
 * Created by PhpStorm.
 * User: joeldg
 * Date: 4/7/17
 * Time: 9:12 PM
 */

namespace Bowhead\Console\Commands;

use Bowhead\Util\Console;
use Bowhead\Console\Kernel;
use Bowhead\Util;
use Illuminate\Console\Command;
#use Bowhead\Jobs\ExampleJob;

/**
 * Class WebsocketCommand
 * @package Bowhead\Console\Commands
 *
 *          This console command is for doing a websocket to GDAX
 *          https://docs.gdax.com/?php#overview
 *
 *          To keep a real-time book of a instrument use level 3
 *          https://docs.gdax.com/?php#get-product-order-book
 *
 *          Then match this up with the proper sequence
 */
class CoinbaseWebsocketCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'bowhead:websocket_coinbase';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Handle the GDAX websocket and display realitime data in the terminal';

    /**
     * @var currency pairs
     */
    protected $instrument;

    /**
     * @var
     */
    protected $console;

    /**
     * @var current book
     */
    public $book;

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $this->console = $util = new Console();

        $this->instrument = 'BTC-USD';
        $loop = \React\EventLoop\Factory::create();
        $connector = new \Ratchet\Client\Connector($loop);

        $connector('wss://ws-feed.gdax.com')
            ->then(function(\Ratchet\Client\WebSocket $conn) {
                $conn->send('{"type": "subscribe","product_id": "'. $this->instrument .'"}');
                $conn->on('message', function(\Ratchet\RFC6455\Messaging\MessageInterface $msg) use ($conn) {
                    /**
                     *   DO ALL PROCESSING HERE
                     *   match up sequence and keep the book up to date.
                     */
                    if (empty($this->book)) {
                        $this->book = $this->getBook($this->instrument);
                        $this->processBook();
                    }
                    $data = json_decode($msg,1);
                    echo $this->console->tableFormatArray($data);

                    #$this->displayPage(json_decode($msg,1));
                    #echo "Received: {$msg}\n";

                    /**  */
                });

                $conn->on('close', function($code = null, $reason = null) {
                    /** log errors here */
                    echo "Connection closed ({$code} - {$reason})\n";
                });

            }, function(\Exception $e) use ($loop) {
                /** hard error */
                echo "Could not connect: {$e->getMessage()}\n";
                $loop->stop();
            });

        $loop->run();
    }


    public function displayPage($message)
    {
        if ($message['type'] == 'match') {
            print_r($message);
        }

        $cols = getenv('COLUMNS');
        $rows = getenv('LINES');

        #print_r($message);

    }


    /**
     * @return mixed
     */
    private function getBook($instrument)
    {
        $util = new Util\Coinbase();
        return $util->get_endpoint('book', null, '?level=2', $instrument);
    }

    /**
     *  reformat $this->book
     */
    private function processBook()
    {
        $_bids = array_reverse($this->book['bids']);
        $_asks = array_reverse($this->book['asks']);

        foreach ($_bids as $bid){
            $bids[$bid[0]] = ($bid[1] * $bid[2]); #array($bid[1], $bid[2], 0);
        }
        foreach ($_asks as $ask){
            $asks[$ask[0]] = ($ask[1] * $ask[2]); #array($ask[1], $ask[2], 0);
        }
        $this->book = array('sell'=>$asks, 'buy'=>$bids);

        #print_r($this->book);
        #die();
    }

    public function displayBook($modify=null){
        $cols = getenv('COLUMNS');
        $rows = getenv('LINES');
        $halfway = round(($rows/2)-1);

        if(!empty($modify)) {
            if ($modify['type'] == 'received' || $modify['type']=='match' ) {
                return true;
            }
            if ($modify['type'] == 'open') {
                if ($modify['side'] == 'sell') {
                    $this->book['sell'][$modify['price']] = array(@$modify['remaining_size'],1,1);
                } else {
                    $this->book['buy'][$modify['price']] = array(@$modify['remaining_size'],1,1);
                }
            }elseif($modify['type'] == 'done'){
                if ($modify['side'] == 'sell') {
                    unset($this->book['sell'][@$modify['price']]);
                } else {
                    unset($this->book['buy'][@$modify['price']]);
                }
            }
        }
        foreach($this->book['sell'] as $key => $sell) {
            $line = str_pad(money_format('%.2n',$key), 10, ' ', STR_PAD_LEFT) . str_pad($sell[0], 15, ' ', STR_PAD_LEFT);
            $color = ($sell[2] == 1 ? 'bg_light_red' : 'light_red');
            $lines[$key] = $this->console->colorize($line, $color) . "\n";
            #$this->book['sell']["$key"][2] = 0;
        }
        krsort($lines);
        $sells = array_slice($lines, -$halfway);
        foreach($sells as $sell) {
            echo $sell;
        }
        echo "----------|-----------------\n";
        $lines = array();
        foreach($this->book['buy'] as $key => $buy) {
            $line = str_pad(money_format('%.2n',$key), 10, ' ', STR_PAD_LEFT) . str_pad($buy[0], 15, ' ', STR_PAD_LEFT);
            $bcolor = ($buy[2] == 1 ? 'bg_light_green' : 'light_green');
            $lines[$key] = $this->console->colorize($line, $bcolor) . "\n";
            #$this->book['buy'][$key][2] = 0;
        }
        ksort($lines);
        $buys = array_slice($lines, -$halfway);
        foreach($buys as $buy) {
            echo $buy;
        }

        return true;
    }
}