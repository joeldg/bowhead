<?php
/**
 * Created by PhpStorm.
 * User: joeldg
 * Date: 1/2/18
 * Time: 5:12 PM
 */

namespace Bowhead\Traits;

use Bowhead\Models as Ccxt_models;
use ccxt\AuthenticationError;
use ccxt\BaseError;

trait DataCcxt
{
    public function get_exchanges()
    {
        $exchanges = \ccxt\Exchange::$exchanges;
        return $exchanges;
    }

    public function update_exchanges()
    {
        $exchanges = \ccxt\Exchange::$exchanges;
        foreach ($exchanges as $exchange) {
            try {
                $classname = '\ccxt\\' . $exchange;
                $class = new $classname (array(
                    'apiKey' => Config::bowhead_config(strtoupper($exchange) . '_APIKEY'),
                    'secret' => Config::bowhead_config(strtoupper($exchange) . '_SECRET'),
                    'uid' => Config::bowhead_config(strtoupper($exchange) . '_UID'),
                    'password' => Config::bowhead_config(strtoupper($exchange) . '_PASSWORD')
                ));
                $urls = $class->urls;

                $ins = [];
                $ins['exchange'] = $exchange;
                $ins['ccxt'] = 1;
                $ins['hasFetchTickers'] = $class->hasFetchTickers ?? 1;
                $ins['hasFetchOHLCV'] = $class->hasFetchOHLCV ?? 1;
                $ins['data'] = json_encode($class->api, 1) . json_encode($urls, 1);
                $ins['url'] = is_array($urls['www']) ? $urls['www'][0] : $urls['www'];
                $ins['url_api'] = is_array($urls['api']) ? array_shift($urls['api']) : $urls['api'];
                $ins['url_doc'] = is_array($urls['doc']) ? $urls['doc'][0] : $urls['doc'];

                $exchange_model = new Ccxt_models\bh_exchanges();
                $exchange_model::updateOrCreate(['exchange' => $exchange], $ins);
            } catch (AuthenticationError $e) {
                echo "\n\t$exchange needs auth (set this exchange to -1 in the database to disable it)..\n\n";
            } catch (BaseError $e) {
                echo "\n\t$exchange error (set this exchange to -1 in the database to disable it):\n $e\n\n";
            }
        }
        return 1;
    }

    public function get_markets($exchange='GDAX')
    {
        $exchange=strtolower($exchange);
        $classname = '\ccxt\\' . $exchange;
        try {
            $class = new $classname (array (
                'apiKey'   => Config::bowhead_config(strtoupper($exchange) .'_APIKEY'),
                'secret'   => Config::bowhead_config(strtoupper($exchange) .'_SECRET'),
                'uid'      => Config::bowhead_config(strtoupper($exchange) .'_UID'),
                'password' => Config::bowhead_config(strtoupper($exchange) .'_PASSWORD')
            ));
            $markets = $class->load_markets();
            return array_keys($markets);
        } catch (AuthenticationError $e) {
            echo "\n\t$exchange needs auth (set this exchange to -1 in the database to disable it)..\n\n";
        } catch (BaseError $e) {
            echo "\n\t$exchange error (set this exchange to -1 in the database to disable it):\n $e\n\n";
        }
    }

    public function update_markets()
    {
        $exchanges = $this->get_exchanges();
        foreach($exchanges as $ex_id => $exchange) {
            usleep(750000); // 0.75 of a second
            $markets = $this->get_markets($exchange);
            if (empty($markets)){
                continue;
            }
            $exch = Ccxt_models\bh_exchanges::where('exchange', '=', $exchange)->get()->first();
            foreach ($markets as $k => $pair) {
                $exid = $exch->id;
                $exchange = $exchange;

                $classname = '\ccxt\\' . $exchange;
                $class = new $classname (array (
                    'apiKey'   => Config::bowhead_config(strtoupper($exchange) .'_APIKEY'),
                    'secret'   => Config::bowhead_config(strtoupper($exchange) .'_SECRET'),
                    'uid'      => Config::bowhead_config(strtoupper($exchange) .'_UID'),
                    'password' => Config::bowhead_config(strtoupper($exchange) .'_PASSWORD')
                ));
                try {
                    echo "updating $exchange / $pair data\n";
                    $pair_model = new Ccxt_models\bh_exchange_pairs();
                    $pair_model::updateOrCreate(['exchange_id' => $exid, 'exchange_pair' => $pair]);
                } catch (AuthenticationError $e) {
                    echo "\n\t$exchange needs auth (set this exchange to -1 in the database to disable it)..\n\n";
                } catch (BaseError $e) {
                    echo "\n\t$exchange error (set this exchange to -1 in the database to disable it):\n $e\n\n";
                }
            }

        }
    }

    public function get_recent($exchange, $market)
    {
        //fetchOrderBook, fetchOHLCV (fetchTrades)
    }

    public function get_ticker($exchange, $market)
    {
        $exchange=strtolower($exchange);
        $classname = '\ccxt\\' . $exchange;
        $class = new $classname (array (
            'apiKey'   => Config::bowhead_config(strtoupper($exchange) .'_APIKEY'),
            'secret'   => Config::bowhead_config(strtoupper($exchange) .'_SECRET'),
            'uid'      => Config::bowhead_config(strtoupper($exchange) .'_UID'),
            'password' => Config::bowhead_config(strtoupper($exchange) .'_PASSWORD')
        ));

        return $class->fetchTicker($market);
    }

    public function createOrder()
    {
        // createLimitBuyOrder, createLimitSellOrder
        // createMarketBuyOrder, createMarketSellOrder
        // cancelOrder
        // fetchOrder, fetchOrders, fetchOpenOrders, fetchClosedOrders
        // fetchMyTrades
        // deposit, withdraw
    }


}