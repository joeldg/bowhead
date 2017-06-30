<?php
/**
 * Created by PhpStorm.
 * User: joeldg
 * Date: 4/8/17
 * Time: 10:49 PM
 */

namespace Bowhead\Util;

use Bowhead\Util\BrokersUtil;
use Webpatser\Uuid;

/**
 * Class Coinbase
 *
 *      Anything to do with managing orders and keeping track of orders on coinbase
 *      https://docs.gdax.com/
 * @package Bowhead\Util
 */
class Coinbase
{
    /**
     * @var mixed
     */
    protected $key;

    /**
     * @var mixed
     */
    protected $secret;

    /**
     * @var mixed
     */
    protected $passphrase;

    /**
     * @var mixed
     */
    protected $url; # https://api-public.sandbox.gdax.com or https://api.gdax.com

    /**
     * @var array
     */
    protected $endpoints = array(
        'accounts'   => array('method' => 'GET', 'uri' => '/accounts'),
        'account'    => array('method' => 'GET', 'uri' => '/accounts/%s'),
        'ledger'     => array('method' => 'GET', 'uri' => '/accounts/%s/ledger'),
        'holds'      => array('method' => 'GET', 'uri' => '/accounts/%s/holds'),
        'place'      => array('method' => 'POST', 'uri' => '/orders'),
        'cancel'     => array('method' => 'DELETE', 'uri' => '/order/%s'),
        'cancel_all' => array('method' => 'DELETE', 'uri' => '/orders/'),
        'orders'     => array('method' => 'GET', 'uri' => '/orders'),
        'order'      => array('method' => 'GET', 'uri' => '/orders/%s'),
        'fills'      => array('method' => 'GET', 'uri' => '/fills'),
        'products'   => array('method' => 'GET', 'uri' => '/products'),
        'book'       => array('method' => 'GET', 'uri' => '/products/%s/book'), // ?level=2
        'ticker'     => array('method' => 'GET', 'uri' => '/products/%s/ticker'),
        'trades'     => array('method' => 'GET', 'uri' => '/products/%s/trades'),
        'stats'      => array('method' => 'GET', 'uri' => '/products/%s/stats'),
        'rates'      => array('method' => 'GET', 'uri' => '/products/%s/candles'),
        'currencies' => array('method' => 'GET', 'uri' =>  '/currencies'),
        'time'       => array('method' => 'GET', 'uri' => '/time'),
        'position'   => array('method' => 'GET', 'uri' => '/position'),
        'reports'    => array('method' => 'GET', 'uri' => '/reports'),
        'coinbase-accounts' => array('method' => 'GET', 'uri' => '/coinbase-accounts'),
    );

    /**
     * @var \Bowhead\Util\BrokersUtil
     */
    protected $util;

    function __construct()
    {
        $this->key        = env('CBKEY');
        $this->secret     = env('CBSECRET');
        $this->passphrase = env('CBPASSPHRASE');
        $this->url        = env('CBURL');
    }

    public function getAccount()
    {
        return $this->get_endpoint('accounts');
    }

    /**
     * @return mixed
     * get both USD/BTC balances on coinbase
     */
    public function get_balances() {
        $jsonReturn = $this->get_endpoint("accounts");
        #error_log(print_r($jsonReturn,1));
        foreach ($jsonReturn as $ret) {
            $user[$ret['currency']]['id'] = $ret['id'];
            $user[$ret['currency']]['balance'] = (float)$ret['balance'];
            $user[$ret['currency']]['hold'] = (float)$ret['hold'];
            $user[$ret['currency']]['available'] = (float)$ret['available'];
            $user[$ret['currency']]['profile_id'] = $ret['profile_id'];
        }
        #error_log("Balances: USD:" . $user['USD']['balance'] . " BTC: ". $user['BTC']['balance'] . " hold: ". $user['BTC']['hold']);
        return $user;
    }

    /**
     * @return mixed
     * https://docs.gdax.com/?php#products
     */
    public function get_instruments()
    {
        return $this->get_endpoint('products');
    }

    /**
     * @param $product_id
     * @param $size
     *
     * @return null|string
     */
    public function market_buy($product_id, $size)
    {
        $data = array(
            'type' => 'market',
            'side' => 'buy',
            'product_id' => $product_id,
            'size' => $size
        );
        return $this->place_order($data);
    }

    /**
     * @param $product_id
     * @param $size
     *
     * @return null|string
     */
    public function market_sell($product_id, $size)
    {
        $data = array(
            'type' => 'market',
            'side' => 'sell',
            'product_id' => $product_id,
            'size' => $size
        );
        return $this->place_order($data);
    }

    /**
     * @param        $product_id
     * @param        $size
     * @param        $price
     * @param string $time_in_force
     * @param null   $cancel_after
     * @param null   $post_only
     *
     * @return null|string
     *
     * see optinns in place_order for timin_force etc
     */
    public function limit_buy($product_id, $size, $price, $time_in_force='GTC', $cancel_after=null, $post_only=null)
    {
        $data = array(
            'type' => 'limit',
            'side' => 'buy',
            'price' => $price,
            'product_id' => $product_id,
            'size' => $size,
            'time_in_force' => $time_in_force
        );
        if(!empty($cancel_after)) {
            $data['cancel_after'] = $cancel_after;
        }
        if(!empty($post_only)) {
            $data['post_only'] = $post_only;
        }
        return $this->place_order($data);
    }

    /**
     * @param        $product_id
     * @param        $size
     * @param        $price
     * @param string $time_in_force
     * @param null   $cancel_after
     * @param null   $post_only
     *
     * @return null|string
     */
    public function limit_sell($product_id, $size, $price, $time_in_force='GTC', $cancel_after=null, $post_only=null)
    {
        $data = array(
            'type' => 'limit',
            'side' => 'sell',
            'price' => $price,
            'product_id' => $product_id,
            'size' => $size,
            'time_in_force' => $time_in_force
        );
        if(!empty($cancel_after)) {
            $data['cancel_after'] = $cancel_after;
        }
        if(!empty($post_only)) {
            $data['post_only'] = $post_only;
        }
        return $this->place_order($data);
    }

    /**
     * @param $product_id
     * @param $size
     * @param $price
     *
     * @return null|string
     */
    public function stop_buy($product_id, $size, $price)
    {
        $data = array(
            'type' => 'market',
            'side' => 'buy',
            'price' => $price,
            'product_id' => $product_id,
            'size' => $size
        );
        return $this->place_order($data);
    }

    /**
     * @param $product_id
     * @param $size
     * @param $price
     *
     * @return null|string
     */
    public function stop_sell($product_id, $size, $price)
    {
        $data = array(
            'type' => 'market',
            'side' => 'sell',
            'price' => $price,
            'product_id' => $product_id,
            'size' => $size
        );
        return $this->place_order($data);
    }

    /**
     * @param $order_id
     *
     * @return mixed
     */
    public function cancel($order_id)
    {
        error_log('CANCEL '. $order_id);
        return $this->get_endpoint('cancel', null, $order_id, 'DELETE');
    }

    /**
     * @param null $side
     *
     * @return array
     */
    function cancel_all_orders($side=null) {
        $ret = array();
        $orders = $this->get_endpoint('orders');
        foreach ($orders as $order) {
            if (!empty($side) && $order['side'] != $side) {
                continue;
            }
            $id = $order['id'];
            $ret[] = $this->cancel($id);
        }
        return $ret;
    }

    /**
     * @return mixed
     */
    public function listorders()
    {
        return $this->get_endpoint('orders');
    }

    /**
     *
     */
    public function getorder()
    {

    }

    /**
     * @param $data array
     * @return null|string
     *
     * https://docs.gdax.com/?php#orders
     */
    public function place_order($data){

        $data['type'] = (empty($data['type']) ? 'limit' : $data['type']); // limit, market, stop
        if (empty($data['side'])) {
            return "error missing side";
        }
        if (!in_array($data['type'], array('limit','market','stop'))){
            return 'ERROR: type must be one of limit/market/stop';
        }
        if (!in_array($data['side'], array('buy','sell'))){
            return 'ERROR: side must be one of buy/sell';
        }

        if (empty($data['time_in_force'])) {
            $data['time_in_force'] = 'GTC';
        }else{
            /**
             *   GTC: Good Til Cancelled - remain open on the book until canceled
             *   GTT: Good Til Time - one min/hour/day via time_in_force
             *   IOC: Immediate Or Cancel - instantly cancel the remaining size of the limit order
             *   FOK: Fill Or Kill - orders are rejected if the entire size cannot be matched.
             */
            if (!in_array($data['time_in_force'], array('GTC', 'GTT', 'IOC', 'FOK'))){
                return "ERROR: time_in_force must be one of GTC/GTT/IOC/FOK";
            }
        }
        if (!empty($data['cancel_after'])){
            /**
             *  one min, one hour or one day ..  no other options :/
             */
            if (!in_array($data['cancel_after'], array('min', 'hour', 'day'))){
                return 'ERROR: cancel_after must be min, hour, day';
            }
            if ($data['time_in_force'] != 'GTT'){
                $data['time_in_force'] = 'GTT'; // just make it GTT instead of error
                #return 'ERROR: when using cancel_after time_in_force must be GTT';
            }
        }
        if (!empty($data['post_only']) && in_array($data['time_in_force'], array('FOK','IOC'))) {
            return 'ERROR: post_only cannot be used with FOK or IOC time_in_force';
        }

        /**
         *   overdraft_enabled and funding_amount are for margin accounts
         */

        $rorder = null;
        $uuid = Uuid\Uuid::generate(4);
        $guid = trim($uuid); // trim mandatory

        // common to all order types
        $order = array(
            'type'       => $data['type'],
            'side'  	 => $data['side'],
            'product_id' => $data['product_id'],
            'client_oid' => $guid
        );
        switch ($data['type']) {
            case 'stop':
                $order['price'] = $data['price'];
                if (!empty($data['size'])){
                    $order['size'] = $data['size'];
                }elseif (!empty($data['funds'])){
                    $order['funds'] = $data['funds'];
                }else{
                    return 'ERROR: market orders must have size or funds set.';
                }
                break;;
            case 'market':
                if (!empty($data['size'])){
                    $order['size'] = $data['size'];
                }elseif (!empty($data['funds'])){
                    $order['funds'] = $data['funds'];
                }else{
                    return 'ERROR: market orders must have size or funds set.';
                }
                break;;
            case 'limit':
            default:
                $order['size'] = $data['size'];
                $order['price'] = $data['price'];
                $order['time_in_force'] = $data['time_in_force'];
                if (!empty($data['cancel_after'])){
                    $order['cancel_after'] = $data['cancel_after'];
                }
                break;;
        }
        $rorder = $this->get_endpoint('place', json_encode($order));
        print_r($rorder);
        if ($rorder) {
            /**
             *  We need to set (internal guid <-> external guid) so we can do lookups in cache
             */
            \Cache::tags(['ledger', 'orders'])->forever('lookup::'.$guid, $rorder['id']);
            \Cache::tags(['ledger', 'orders'])->forever('lookup::'.$rorder['id'], $guid);
            \Cache::tags(['ledger', 'orders'])->put($rorder['id'], $rorder);
            error_log(strtoupper($data['side']) .' - '. json_encode($rorder));
        } else {
            error_log(strtoupper($data['side']) .' - '. "failed to purchase ". $data['size'] .' at '. $data['price']);
        }
        return $rorder;
    }

    /**
     * @param      $point
     * @param null $data
     * @param null $extra
     *
     * @return mixed
     */
    public function get_endpoint($point, $data=null, $extra=null, $instrument='ETH-USD', $method='GET') {
        $timestamp  = time();
        $key = $this->key;
        $passphrase = $this->passphrase;

        extract($this->endpoints[$point]); // provide method and uri
        # TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO
        # TODO do sprintf on uri for instrument/product and other %s
        #
        $uri = sprintf($uri, $instrument);
        #error_log('get_endpoint : '.$uri);
        $uri = $uri . $extra;
        $sig = $this->sign($timestamp, $method . $uri . $data, $this->secret);

        $headers = array(
            'User-Agent: GDAX_cl_trader',
            'Content-Type: application/json',
            "CB-ACCESS-KEY: $key",
            "CB-ACCESS-SIGN: $sig",
            "CB-ACCESS-TIMESTAMP: $timestamp",
            "CB-ACCESS-PASSPHRASE: $passphrase",
        );
        #error_log($uri);
        #error_log(print_r($headers,1));
        $apireturn = $this->call($point, $headers, $data, $extra, $instrument, $method);
        return json_decode($apireturn['body'],1);
    }
    /**
     * @param $timestamp
     * @param $data
     * @param $secret
     *
     * @return string
     */
    public function sign($timestamp, $data, $secret) {
        return base64_encode(hash_hmac(
            'sha256',
            $timestamp . $data,
            base64_decode($secret),
            true
        ));
    }

    /**
     * @param        $endpoint
     * @param        $headers
     * @param string $body
     * @param null   $extra
     *
     * @return array
     */
    public function call($endpoint, $headers, $body = '', $extra = null, $instrument='ETH-USD', $method='GET') {
        extract($this->endpoints[$endpoint]);
        $uri = sprintf($uri, $instrument);
        #error_log('call : '.$uri);
        $uri = $uri . $extra;
        $url = $this->url . $uri;
        #error_log($url);
        #error_log($body);
        $curl = curl_init();

        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_RETURNTRANSFER => true,
        );

        $method = strtolower($method);
        if ($method == 'get') {
            $options[CURLOPT_HTTPGET] = 1;
        } else if ($method == 'post') {
            $options[CURLOPT_POST] = 1;
            $options[CURLOPT_POSTFIELDS] = $body;
        } else if ($method == 'delete') {
            $options[CURLOPT_CUSTOMREQUEST] = "DELETE";
        } else if ($method == 'put') {
            $options[CURLOPT_CUSTOMREQUEST] = "PUT";
            $options[CURLOPT_POSTFIELDS] = $body;
        }
        #error_log(print_r($options,1));
        curl_setopt_array($curl, $options);
        $response = curl_exec($curl);
        if ($response === false) {
            $error = curl_errno($curl);
            $message = curl_error($curl);
            curl_close($curl);
            #error_log('NETWORK ERROR', $message . " (" . $error . ")");
        }

        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if($statusCode != 200) {
            print_r($response);
            error_log('STATUS CODE', $statusCode . ' ' . $response);
        }
        return array( "statusCode" => $statusCode, "body" => $response );
    }
}