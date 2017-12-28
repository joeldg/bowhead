<?php
/**
 * Created by PhpStorm.
 * User: joeldg
 * Date: 6/13/17
 * Time: 4:43 PM
 */

namespace Bowhead\Traits;

use Bowhead\Util\Whaleclub;
use Bowhead\Util\Coinbase;
use Bowhead\Util\Bitfinex;
use Bowhead\Util\OneBroker;

/**
 * Class Mapper
 * @package Bowhead\Traits
 *
 *          the various brokerages and market makers return data in different ways.
 *          we need a mapping between them all so we can have a generic interface to
 *          use them.
 *
 */
trait Mapper
{
    protected $mapped_brokers_list = ['whaleclub','OneBroker','Coinbase','Bitfinex'];

    /**
     * @var array
     *   mappings *maps* [our base methods] => [brokerage class methods.]
     *  if | found, search for replacement to pass to function
     *          use string unless
     *          or use variable if passed in {}
     *          or use array if passed in []
     *
     *          if more than one variable needs to be passed, use a wrapper that accepts an array of values to
     *          map to the methods.
     */
    protected $api_mappings = [

        /** These are the brokerages we are starting with, adding more as we go */
        'apis'        => ['Whaleclub','OneBroker','Coinbase','Bitfinex','poloniex','oanda']

        /** mappings */
        , 'Whaleclub' => [
            /** account */
              'accounts_all'             => 'getBalance'

            , 'account_deposits'         => 'getTransactions|deposits'
            , 'account_withdrawals'      => 'getTransactions|withdrawals'
            , 'account_referrals'        => 'getTransactions|referrals'
            , 'account_bonuses'          => 'getTransactions|bonuses'

            , 'account_deposit_address'  => ''

            /** markets */
            , 'markets_all'              => 'getMarkets'
            , 'market_get'               => 'getMarkets|{id}'
            , 'market_price'             => 'getPrice|{id}'

            /** positions */
            , 'positions_active'         => 'positionsList|active'
            , 'positions_pending'        => 'positionsList|pending'
            , 'positions_closed'         => 'positionsList|closed'

            , 'position_get'             => 'positionGet|{id}'
            , 'position_open'            => 'positionNew|[order]'
            , 'position_update'          => 'positionClose|[order]'
            , 'position_close'           => 'positionClose|{id}'
            , 'position_cancel'          => 'positionCancel|{id}'

            /** options/turbo 1min and 5min contracts */
            , 'position_opts_active'     => 'turboPositions|active'
            , 'position_opts_closed'     => 'turboPositions|closed'
            , 'position_opts_get'        => 'turboGetPosition|{id}'
            , 'position_opts_open'       => 'wrapturboNew|[order]'
            , 'position_opts_contracts'  => 'turboContracts'
        ]
        , 'OneBroker'   => [
            /** account */
             'accounts_all'             => 'userDetailsGet'

            , 'account_deposits'         => ''
            , 'account_withdrawals'      => ''
            , 'account_referrals'        => ''
            , 'account_bonuses'          => ''

            , 'account_deposit_address'  => '' // https://1broker.com/?c=en/content/api-documentation#user-bitcoin

            /** markets */
            , 'markets_all'              => 'getAllSymbols'
            , 'market_get'               => 'getMarketDetails|{id}'
            , 'market_price'             => 'getMarketQuotes|{id}'

            /** positions */
            , 'positions_active'         => 'getOpenPositions'
            , 'positions_pending'        => 'getOpenOrders'
            , 'positions_closed'         => 'getPositionHistory'

            , 'position_get'             => 'positionSharedGet|{id}'
            , 'position_open'            => 'createOrder|[order]'
            , 'position_update'          => 'positionEdit|[order]'
            , 'position_close'           => 'positionClose|{id}'
            , 'position_cancel'          => 'cancelOrder|{id}'

        ]
        , 'Coinbase'  => [
            /** account */
            'accounts_all'             => 'getAccount'

            , 'account_deposits'         => ''
            , 'account_withdrawals'      => ''
            , 'account_referrals'        => ''
            , 'account_bonuses'          => ''

            , 'account_deposit_address'  => ''

            /** markets */
            , 'markets_all'              => 'get_instruments'
            , 'market_get'               => ''
            , 'market_price'             => ''

            /** positions */
            , 'positions_active'         => 'listorders'
            , 'positions_pending'        => 'getOpenOrders'
            , 'positions_closed'         => 'getPositionHistory'

            , 'position_get'             => ''
            , 'position_open'            => 'place_order|[order]'
            , 'position_update'          => ''
            , 'position_close'           => 'cancel|{id}'
            , 'position_cancel'          => 'cancel|{id}'
        ]
        , 'Bitfinex'  => [
            /** account */
            'accounts_all'             => 'fetch_balance'

            , 'account_deposits'         => ''
            , 'account_withdrawals'      => ''
            , 'account_referrals'        => ''
            , 'account_bonuses'          => ''

            , 'account_deposit_address'  => ''

            /** markets */
            , 'markets_all'              => ''
            , 'market_get'               => ''
            , 'market_price'             => ''

            /** positions */
            , 'positions_active'         => 'positions'
            , 'positions_pending'        => ''
            , 'positions_closed'         => ''

            , 'position_get'             => ''
            , 'position_open'            => 'new_order_wrap|[order]'
            , 'position_update'          => ''
            , 'position_close'           => 'close_position|{id}'
            , 'position_cancel'          => 'cancel_order|{id}'
        ]
        , 'poloniex'  => []
        , 'oanda'     => []
    ];

    /**
     * @param $source
     * @param $data
     *
     * @return mixed
     *
     *  USE THE ABOVE MAPPINGS AND CALL THE CLASS WITH THE APPROPRIATE FUNCTION.
     */
    public function mapperAccounts($source, $data)
    {
       switch ($source) {
           case 'Whaleclub':
               $instance = new Whaleclub('BTC/USD');
               break;
           case 'OneBroker':
               $instance = new OneBroker();
               break;
           case 'Coinbase':
               $instance = new Coinbase();
               break;
           case 'Bitfinex':
               $instance = new Bitfinex(env('BITFINIX_KEY'), env('BITFINIX_SECRET'));
               break;
           default:
               $instance = new Whaleclub('BTC/USD');
               break;
       }

        $map = $this->api_mappings[$source]; // grab mappings for this class
        $action = $map[$data['action']];     // grab the current mapping

        // process the mapping
        if (strpos($action, '|')) {
            $parts = explode('|', $action);
            // id passed
            if ($parts[1] == "{id}") {
                return call_user_func_array(array($instance, $parts[0]), array($data['id']));
            }
            // array passed
            if ($parts[1] == '[order]') {
                return call_user_func_array(array($instance, $parts[0]), array($data['order']));
            }
        } else {
            // plain call
            return call_user_func_array(array($instance, $action), array());
        }
    }
}