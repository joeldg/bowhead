<?php
/**
 * Created by PhpStorm.
 * User: joeldg
 * Date: 1/2/18
 * Time: 5:11 PM
 */

namespace Bowhead\Traits;

use GuzzleHttp as Coingy_GuzzleHttp;
use Bowhead\Models as Coingy_models;
use Bowhead\Util\Coinigy;

/**
 * Class Coinigy
 * @package Bowhead\Traits
 *
 *          REST: https://api.coinigy.com/api/v1/
 *          WEBSOCKET: wss://sc-02.coinigy.com/socketcluster/
 */
trait DataCoinigy
{
    protected $txtime;

    private function call_coinigy($endpoint='exchanges', $data=null)
    {
        $base_url = 'https://api.coinigy.com/api/v1/';
        $headers['X-API-KEY']    = Config::bowhead_config('COINIGY_API');
        $headers['X-API-SECRET'] = Config::bowhead_config('COINIGY_SEC');

        $client = new Coingy_GuzzleHttp\Client([
            'base_uri' => $base_url
            , 'headers' => $headers
            , 'on_stats' => function (Coingy_GuzzleHttp\TransferStats $stats) {
                $this->txtime = $stats->getTransferTime();
            }
        ]);
        if (!empty($data)){
            $response = $client->post($endpoint, ['form_params' => $data]);
        } else {
            $response = $client->post($endpoint);
        }
        $code = $response->getStatusCode();
        if ($code == '200') {
            return json_decode($response->getBody(), 1);
        } else {
            $reason = $response->getReasonPhrase();
            return ['error'=>$reason];
        }

    }

    public function get_accounts()
    {
        return $this->call_coinigy('accounts');
    }

    public function update_accounts()
    {
        return $this->call_coinigy('accounts');
    }

    public function get_exchanges()
    {
        return $this->call_coinigy('exchanges');
    }

    public function update_exchanges()
    {
        $exchanges = $this->get_exchanges();
        foreach($exchanges['data'] as $k => $exchange) {
            $ins = [];
            $ins['coinigy']                 =1;
            $ins['exchange']                = $exchange['exch_name'];
            $ins['coinigy_id']              = $exchange['exch_id'];
            $ins['coinigy_exch_code']       = $exchange['exch_code'];
            $ins['coinigy_exch_fee']        = $exchange['exch_fee'];
            $ins['coinigy_trade_enabled']   = $exchange['exch_trade_enabled'];
            $ins['coinigy_balance_enabled'] = $exchange['exch_balance_enabled'];
            $ins['data']                    = $exchange['exch_url'];
            $ins['url']                     = $exchange['exch_url'];

            $exchange_model = new Coingy_models\bh_exchanges();
            $exchange_model::updateOrCreate(['exchange' => $exchange['exch_name']], $ins);
        }
        return 1;
    }

    public function get_markets($exchange='GDAX')
    {
        return $this->call_coinigy('markets', ['exchange_code' => $exchange]);
    }

    public function update_markets()
    {
        $exchanges = $this->get_exchanges();
        foreach($exchanges['data'] as $k => $exchange) {
            usleep(750000); // 0.75 of a second
            $exchanges = $this->get_markets($exchange['exch_code']);
            $exchanges = $exchanges['data'];
            foreach ($exchanges as $ex) {
                $pair_model = new Coingy_models\bh_exchange_pairs();
                $pair_model::updateOrCreate(['exchange_id' => $ex['exch_id'], 'market_id'=>$ex['mkt_id'], 'exchange_pair' => $ex['mkt_name']]);
            }
            echo "Done with ". $exchange['exch_name'] ." .... \n";
        }
        return 1;
    }

    public function get_history($exchange, $market)
    {
        //https://coinigy.docs.apiary.io/#reference/market-data/market-data/data-{type:all}
        return $this->call_coinigy('data', ['exchange_code' => $exchange, 'exchange_market'=>$market, 'type'=>'history']);
    }

    public function get_ticker($exchange, $market)
    {
        https://coinigy.docs.apiary.io/#reference/market-data/price-ticker/ticker
        return $this->call_coinigy('ticker', ['exchange_code' => $exchange, 'exchange_market'=>$market]);
    }

    // see https://coinigy.docs.apiary.io/#reference/account-functions/update-tickers/ordertypes
    /**
     *  1 - Buy
     *  2 - Sell
     *  3 - Limit
     *  6 - Stop (Limit)
     *  8 - Limit (Margin)
     *  9 - Stop Limit (Margin)
     */
    public function create_order()
    {
        # TODO
    }

    public function cancel_order()
    {
        # TODO
    }

    public function get_orders()
    {
        #TODO - both open and closed/history
    }

    public function update_orders()
    {
        # TODO
    }

    public function get_orderbook()
    {
        #TODO - bids/asks
    }
}