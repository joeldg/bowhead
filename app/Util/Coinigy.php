<?php
/**
 * Created by PhpStorm.
 * User: joeldg
 * Date: 1/7/18
 * Time: 1:00 AM
 */
namespace Bowhead\Util;
/**
 * Class Coinigy
 * $coinigy_api = new Coinigy();
 * $coinigy_api->exchanges();
 * $coinigy_api->markets('OK');
 *
 *  Originally from here https://github.com/coinigy/api/blob/master/example_v1.php
 *  I have added a few things below, but kept the original for the most part.
 *  Most especially I fixed the crazy spacing and formatting in the orginal file and added phpdoc blocks
 *
 */
class Coinigy
{
    use \Bowhead\Traits\Config;

    /**
     * @var string
     */
    private $coinigy_api_key;

    /**
     * @var string
     */
    private $coinigy_api_secret;

    /**
     * @var string
     */
    private $endpoint;

    /**
     * Coinigy constructor.
     */
    function __construct()
    {
        //see API docs for more info
        $this->coinigy_api_key = \Bowhead\Traits\Config::bowhead_config('COINIGY_API');
        $this->coinigy_api_secret = \Bowhead\Traits\Config::bowhead_config('COINIGY_SEC');
        $this->endpoint = 'https://api.coinigy.com/api/v1/'; //with trailing slash
    }

    public function userInfo()
    {
        $post_arr = array();
        $result = $this->doWebRequest('userInfo', $post_arr);
        return $result;
    }

    public function accounts()
    {
        $post_arr = array();
        $result = $this->doWebRequest('accounts', $post_arr);
        return $result;
    }

    public function activity()
    {
        $post_arr = array();
        $result = $this->doWebRequest('activity', $post_arr);
        return $result;
    }

    /**
     * @param $auth_ids
     */
    public function balances($auth_ids)
    {
        $post_arr = array();
        $post_arr["auth_ids"] = $auth_ids;

        $result = $this->doWebRequest('balances', $post_arr);
        return $result;
    }

    public function pushNotifications()
    {
        $post_arr = array();
        $result = $this->doWebRequest('pushNotifications', $post_arr);
        return $result;
    }

    public function user_orders()
    {
        $post_arr = array();
        $result = $this->doWebRequest('orders', $post_arr);
        return $result;
    }

    public function alerts()
    {
        $post_arr = array();
        $result = $this->doWebRequest('alerts', $post_arr);
        return $result;
    }

    public function exchanges()
    {
        $post_arr = array();
        $result = $this->doWebRequest('exchanges', $post_arr);
        return $result;
    }

    /**
     * @param $exchange_code
     */
    public function markets($exchange_code)
    {
        $post_arr = array();
        $post_arr["exchange_code"] = $exchange_code;

        $result = $this->doWebRequest('markets', $post_arr);
        return $result;
    }

    /**
     * @param $exchange_code
     * @param $exchange_market
     */
    public function history($exchange_code, $exchange_market)
    {
        $post_arr = array();
        $post_arr["exchange_code"] = $exchange_code;
        $post_arr["exchange_market"] = $exchange_market;
        $post_arr["type"] = "history";


        $result = $this->doWebRequest('data', $post_arr);
        return $result;
    }

    /**
     * @param $exchange_code
     * @param $exchange_market
     */
    public function asks($exchange_code, $exchange_market)
    {
        $post_arr = array();
        $post_arr["exchange_code"] = $exchange_code;
        $post_arr["exchange_market"] = $exchange_market;
        $post_arr["type"] = "asks";

        $result = $this->doWebRequest('data', $post_arr);
        return $result;
    }

    /**
     * @param $exchange_code
     * @param $exchange_market
     */
    public function bids($exchange_code, $exchange_market)
    {
        $post_arr = array();
        $post_arr["exchange_code"] = $exchange_code;
        $post_arr["exchange_market"] = $exchange_market;
        $post_arr["type"] = "bids";

        $result = $this->doWebRequest('data', $post_arr);
        return $result;
    }

    //asks + bids + history
    /**
     * @param $exchange_code
     * @param $exchange_market
     */
    public function data($exchange_code, $exchange_market)
    {
        $post_arr = array();
        $post_arr["exchange_code"] = $exchange_code;
        $post_arr["exchange_market"] = $exchange_market;
        $post_arr["type"] = "all";

        $result = $this->doWebRequest('data', $post_arr);
        return $result;
    }

    //asks + bids
    /**
     * @param $exchange_code
     * @param $exchange_market
     */
    public function orders($exchange_code, $exchange_market)
    {

        $post_arr = array();
        $post_arr["exchange_code"] = $exchange_code;
        $post_arr["exchange_market"] = $exchange_market;
        $post_arr["type"] = "orders";

        $result = $this->doWebRequest('data', $post_arr);

        return $result;
    }

    public function newsFeed()
    {
        $post_arr = array();

        $result = $this->doWebRequest('newsFeed', $post_arr);
        return $result;
    }


    public function orderTypes()
    {
        $post_arr = array();
        $result = $this->doWebRequest('orderTypes', $post_arr);
        return $result;
    }

    /**
    ////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////
    //////////////////////                      ////////////////////////////////////////
    /////////////            ACTION METHODS         ////////////////////////////////////
    /////////////////////                       ////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////
    //*/

    /**
     * @param $auth_id
     */
    public function refreshBalance($auth_id)
    {

        $post_arr = array();
        $post_arr["auth_id"] = $auth_id;

        $result = $this->doWebRequest('refreshBalance', $post_arr);
        return $result;
    }

    /**
     * @param $exchange_code
     * @param $exchange_market
     * @param $alert_price
     */
    public function addAlert($exchange_code, $exchange_market, $alert_price)
    {
        $post_arr = array();
        $post_arr["exch_code"] = $exchange_code;
        $post_arr["market_name"] = $exchange_market;
        $post_arr["alert_price"] = $alert_price;

        $result = $this->doWebRequest('addAlert', $post_arr);
        return $result;
    }

    /**
     * @param $delete_alert_id
     */
    public function deleteAlert($delete_alert_id)
    {
        $post_arr = array();
        $post_arr["alert_id"] = $delete_alert_id;

        $result = $this->doWebRequest('deleteAlert', $post_arr);
        return $result;
    }

    /**
     * @param $order_auth_id
     * @param $order_exch_id
     * @param $order_mkt_id
     * @param $order_type_id
     * @param $price_type_id
     * @param $limit_price
     * @param $stop_price
     * @param $order_quantity
     */
    public function addOrder($order_auth_id, $order_exch_id, $order_mkt_id, $order_type_id, $price_type_id, $limit_price, $stop_price, $order_quantity)
    {
        $post_arr = array();
        $post_arr["auth_id"] = $order_auth_id;
        $post_arr["exch_id"] = $order_exch_id;
        $post_arr["mkt_id"] = $order_mkt_id;
        $post_arr["order_type_id"] = $order_type_id;
        $post_arr["price_type_id"] = $price_type_id;
        $post_arr["limit_price"] =$limit_price;
        $post_arr["stop_price"] = $stop_price;
        $post_arr["order_quantity"] = $order_quantity;

        $result = $this->doWebRequest('addOrder', $post_arr);
        return $result;

    }

    /**
     * @param $cancel_order_id
     */
    public function cancelOrder($cancel_order_id)
    {
        $post_arr = array();
        $post_arr["internal_order_id"] = $cancel_order_id;

        $result = $this->doWebRequest('cancelOrder', $post_arr);
        return $result;

    }

    /**
     * @param $method
     * @param $post_arr
     *
     * @return bool|mixed
     */
    private function doWebRequest($method, $post_arr)
    {

        $url = $this->endpoint.$method;

        $headers = array('X-API-KEY: ' . $this->coinigy_api_key,
            'X-API-SECRET: ' . $this->coinigy_api_secret);


        // our curl handle (initialize if required)
        static $ch = null;
        if (is_null($ch)) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; Bowhead; '.php_uname('s').'; PHP/'.phpversion().')');
        }

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_arr);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
        $res = curl_exec($ch);

        if ($res === false)  {
            echo "CURL Failed - Check URL";
            return false;
        }

        $dec = json_decode($res, 1);
        if (!$dec) {
            echo "Invalid JSON returned - Redirect to Login";
            return false;
        }

        return $dec;

    }

    /**
     * @param $result
     */
    private function output_result($result)
    {
        if($result)
        {
            if(isset($result->error))
                $this->pre($result->error);
            elseif(isset($result))
                $this->pre($result);
        }
    }

    /**
     * @param $array
     */
    private function pre($array) {
        echo "<pre>".print_r($array, true)."</pre>";
    }

}