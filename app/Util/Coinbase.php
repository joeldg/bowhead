<?php
/**
 * Created by PhpStorm.
 * User: joeldg
 * Date: 4/8/17
 * Time: 10:49 PM
 */

namespace Bowhead\Util;

use Bowhead\Util\BrokersUtil;

/**
 * Class Coinbase
 *
 *      Anything to do with managing orders and keeping track of orders on coinbase
 *      https://docs.gdax.com/
 * @package Bowhead\Util
 */
class Coinbase
{
    protected $util;

    function __construct()
    {
        $this->util = new BrokersUtil();
    }

    public function getAccount()
    {
        return $this->util->get_endpoint('accounts');
    }

    /**
     * @return mixed
     * https://docs.gdax.com/?php#products
     */
    public function get_instruments()
    {
        return $this->util->get_endpoint('products');
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
        return $this->util->get_endpoint('cancel', null, $order_id, 'DELETE');
    }

    /**
     * @param null $side
     *
     * @return array
     */
    function cancel_all_orders($side=null) {
        $ret = array();
        $orders = $this->util->get_endpoint('orders');
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
        return $this->util->get_endpoint('orders');
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
        $guid = $this->util->guid(); // this needs to be marked in cache after the order

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

        $rorder = $this->util->get_endpoint('place', json_encode($order));
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
}