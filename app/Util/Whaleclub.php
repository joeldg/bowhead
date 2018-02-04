<?php
/**
 * Created by PhpStorm.
 * User: joeldg
 * Date: 4/8/17
 * Time: 9:36 PM.
 */

namespace Bowhead\Util;

/**
 * Class orcaStrategy.
 */
class Whaleclub
{
    /**
     * Instrument = BTC_USD, ETH_USD and so on.
     *
     * @var
     */
    protected $instrument;

    /**
     * @var mixed
     */
    protected $token;

    /**
     * @var string
     */
    protected $base_url = 'https://api.whaleclub.co/v1/';

    /**
     * @var string
     */
    protected $description = 'Whaleclub API wrapper';

    /**
     * @var array
     *            override array for configs items
     */
    protected $configs = ['SELL_HOLD_TICKS'=>25];

    /**
     * testStrategy constructor.
     *
     * @param $instrument
     */
    public function __construct($instrument = 'BTC/USD')
    {
        $this->token = env('WHALECLUB_TOKEN');
        $this->instrument = $instrument;
    }

    public function get_headers_from_curl_response($response)
    {
        $headers = [];
        $header_text = substr($response, 0, strpos($response, "\r\n\r\n"));
        foreach (explode("\r\n", $header_text) as $i => $line) {
            if ($i === 0) {
                $headers['http_code'] = $line;
            } else {
                list($key, $value) = explode(': ', $line);

                $headers[$key] = $value;
            }
        }

        return $headers;
    }

    public function callWC($url, $data = false, $method = 'GET', $json = false)
    {
        $responses = [
            /* http://docs.whaleclub.co/#errors */
             200 => 'OK', 201 => 'Success', 400 => 'Validation Error – unable to validate POST/PUT request', 401 => 'Unauthorized – invalid API token', 402 => 'Failed Request', 403 => 'Forbidden', 404 => 'Resource Not Found', 422 => 'Unprocessable Entity – there was an issue parsing your request', 423 => 'Blocked – you’ve been blocked from making API requests', 429 => 'Rate Limit Exceeded – too many requests', 500 => 'Internal Server Error – Whaleclub server error',
        ];

        $token = $this->token;
        $curl = curl_init($this->base_url.$url);
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            //CURLOPT_TIMEOUT        => 5,
            //CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => "$method",
            CURLOPT_HTTPHEADER     => [
                 'cache-control: no-cache', "Authorization: Bearer $token", base64_decode('UGFydG5lci1JRDogdW41NWgzaGRxdVA5VEZ3UEo='),
            ],
        ]);
        if (is_array($data)) {
            $_data = http_build_query($data);
            //echo $_data . "\n";
            curl_setopt($curl, CURLOPT_POSTFIELDS, $_data);
        }

        $body = curl_exec($curl);
        $err = curl_error($curl);

        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        //$headers   = $this->get_headers_from_curl_response($body);
        //$xrate_limit  = $headers['X-RateLimit-Limit']     ?? '';
        //$xrate_remain = $headers['X-RateLimit-Remaining'] ?? '';
        //$xrate_reset  = $headers['X-RateLimit-Reset']     ?? '';
        $body = json_decode($body, 1);
        curl_close($curl);

        if ($err || $http_code != 200) {
            $ret = [
                'err'      => 1,
                'error'    => $err,
                'response' => ($responses[$http_code] ?? 'Unknown:'.$http_code),
                'body'     => $body,
            ];

            return $json ? json_encode($ret, 1) : $ret;
        } else {
            $body['err'] = 0;

            return $json ? json_encode($body, 1) : $body;
        }
    }

    /**
     * @param int $trim
     *
     * @return array|mixed|string
     *                            http://docs.whaleclub.co/#markets
     *                            this is just a list of pairs wc works with
     */
    public function getMarkets($trim = 1)
    {
        $ret = $this->callWC('markets/'.$this->instrument);

        return $trim ? $ret[$this->instrument] : $ret;
    }

    /**
     * @param int $trim
     *
     * @return array|mixed|string
     *
     * [bid] => 2088.5
     * [ask] => 2127.5
     * [state] => open
     * [last_updated] => 1495838365
     */
    public function getPrice($instrument, $trim = 1)
    {
        $ret = $this->callWC('price/'.$instrument);
        $ask = $ret[$instrument]['ask'] ?? 0;
        $bid = $ret[$instrument]['bid'] ?? 0;
        $ret[$instrument]['price'] = ($ask + $bid) / 2;
        $ret[$instrument]['spread'] = $ask - $bid;

        return $trim ? $ret[$instrument] : $ret;
    }

    /**
     * @return array|mixed|string
     *                            http://docs.whaleclub.co/#balance
     *
     * [last_updated] => 1495743004
     * [currency] => BTC
     * [total_amount] => 501981032
     * [available_amount] => 501981032
     * [active_amount] => Array
     * (
     *      [BTC-USD] => 0
     *      [LTC-USD] => 0
     *      [USD-JPY] => 0
     * )
     *
     * [pending_amount] => Array
     * (
     *      [BTC-USD] => 0
     * )
     */
    public function getBalance()
    {
        $ret = $this->callWC('balance');

        return $ret;
    }

    /**
     * @param string $type
     *
     * @return array|mixed|string
     *                            http://docs.whaleclub.co/#transactions
     *                            deposits, withdrawals, referrals, or bonuses
     */
    public function getTransactions($type = 'deposits')
    {
        $ret = $this->callWC("transactions/$type");

        return $ret;
    }

    /**
     * @param $state
     * http://docs.whaleclub.co/#list-positions
     *
     * pending, active, or closed
     *
     * Example position object http://docs.whaleclub.co/#position-object
     * {
     * "id"                   : "s6pwQ4nyS4Z7jHRvJ",
     * "slug"                 : "47n2728b3",
     * "direction"            : "long",
     * "market"               : "NFLX",
     * "leverage"             : 10,
     * "type"                 : "limit",
     * "state"                : "closed",
     * "size"                 : 2000000000,
     * "margin_size"          : 200000000,
     * "entry_price"          : 99,
     * "stop_loss"            : 96.5,
     * "take_profit"          : 126,
     * "close_reason"         : "market",  at_market, at_stop, at_target, or liquidation
     * "close_price"          : 122.81,
     * "profit"               : 481000000,  (closed)
     * "created_at"           : 1465795498,
     * "entered_at"           : 1465795598,
     * "closed_at"            : 1465799498,
     * "last_updated"         : 1465797498,
     * "liquidation_price"    : 91.08,
     * "financing"            : 120000,
     * "currency"             : "BTC"
     * },
     */
    public function positionsList($state = 'active')
    {
        $ret = $this->callWC("positions/$state");

        return $ret;
    }

    /**
     * @param $id
     *
     * @return bool
     *              http://docs.whaleclub.co/#get-position
     */
    public function positionGet($id)
    {
        if (empty($id)) {
            return false;
        }
        $ret = $this->callWC("position/$id");

        return $ret;
    }

    /**
     * @param $order
     * http://docs.whaleclub.co/#new-position
     *
     *   Req: direction, market, leverage, size (in satoshis)
     *   Opt: entry_price, stop_loss, stop_loss_trailing, take_profit
     */
    public function positionNew($order = [])
    {
        // size is passed in satoshi units, which are BTC parts of 100,000,000
        $order['size'] = ($order['size'] * 100000000) ?? (0.01 * 100000000);
        $order['direction'] = $order['direction'] ?? 'long';
        $order['market'] = $order['market'] ?? $this->instrument;
        $order['leverage'] = $order['leverage'] ?? 10;
        $order['entry_price'] = $order['entry_price'] ?? 0;
        $order['stop_loss'] = $order['stop_loss'] ?? 0;
        $order['stop_loss_trailing'] = $order['stop_loss_trailing'] ?? 'true';
        $order['take_profit'] = $order['take_profit'] ?? 0;

        $ret = $this->callWC('position/new', $order, 'POST');
        if (!empty($ret['err'])) {
            return $ret['body'];
        }
        $err = $ret['error'] ?? null;
        if ($err) {
            return $err;
        }

        return $ret['body'];
    }

    /**
     * @param       $id
     * @param array $order
     *
     * @return array|bool|mixed|string
     *                                 stop_loss, stop_loss_trailing, take_profit
     *                                 NOTE NOTE NOTE NOTE
     *                                 stop_loss_trailing does not seem to work in the API
     *                                 tested with command line curl, php and a few others.
     */
    public function positionUpdate($id, $order = [])
    {
        echo "update $id\n";
        print_r($order);
        if (empty($id)) {
            return false;
        }
        $ret = $this->callWC("position/update/$id", $order, 'PUT');

        return $ret;
    }

    /**
     * @param $id
     *
     * @return array|mixed|string
     *                            http://docs.whaleclub.co/#close-position
     *                            id can be comma list
     */
    public function positionClose($id)
    {
        $ret = $this->callWC("position/close/$id", [], 'PUT');

        return $ret;
    }

    /**
     * @param $id
     *
     * @return array|mixed|string
     *
     *  for pending
     */
    public function positionCancel($id)
    {
        $ret = $this->callWC("position/cancel/$id", [], 'PUT');

        return $ret;
    }

    /**
     * @param     $id
     * @param int $split
     *
     * @return array|mixed|string
     *
     *      split up a position, ration between 5 and 95
     */
    public function positionSplit($id, $split = 50)
    {
        $ret = $this->callWC("position/split/$id", ['ratio'=>$split], 'POST');

        return $ret;
    }

    /** ***************************************************************************************************************
     *    TURBO TURBO TURBO  TURBO TURBO TURBO TURBO TURBO TURBO TURBO TURBO TURBO TURBO TURBO TURBO TURBO TURBO TURBO.
     *************************************************************************************************************** */
    /**
     *  TURBO is a winner-take-all *bet* that a market will be 'up' or be 'down'..
     *
     *  In Forex this is normally called a binary option.
     *
     *  BTC rates are 35% for a correct prediction 5mins out
     *  If you are wrong you lose 100% of your bet.
     *
     *  Obviously dangerous, but in large swinging markets like BTC where if a massive dip happens then you can
     *  safely turbo a sell.
     *
     *  USE WITH EXTREME CAUTION UNLESS VERY SPECIFIC
     */

    /**
     * @return array|mixed|string
     *                            http://docs.whaleclub.co/#get-active-contracts
     */
    public function turboContracts()
    {
        $ret = $this->callWC('contracts');

        return $ret;
    }

    /**
     * @param string $state
     *
     * @return array|mixed|string
     */
    public function turboPositions($state = 'active')
    {
        $ret = $this->callWC("positions-turbo/$state");

        return $ret;
    }

    /**
     * @param $id
     *
     * @return array|mixed|string
     */
    public function turboGetPosition($id)
    {
        $ret = $this->callWC("position-turbo/$id");

        return $ret;
    }

    /**
     * @param $order
     *
     * @return array|mixed|string
     *                            direction, market, type (1min/5min), size (in satoshis)
     *                            {
     *                            "id": "uWchea2SocXZHEiHS",
     *                            "contract_id": "QvgMMkF35kSKowAtf",
     *                            "direction": "long",
     *                            "market": "EUR-USD",
     *                            "state": "active",
     *                            "size": 10000000,
     *                            "entry_price": 1.11825,
     *                            "payoff": 0.55,
     *                            "created_at": 1464873229,
     *                            "expires_at": 1464873429,
     *                            "currency": "BTC"
     *                            }
     */
    public function turboNew($direction = 'long', $market = 'BTC-USD', $type = '5min', $size = 10000000)
    {
        $order = [
             'direction' => $direction, 'market'    => $market, 'type'      => $type, 'size'      => $size,
        ];
        $ret = $this->callWC('position-turbo/new', $order, 'POST');
        print_r($ret);

        return $ret;
    }

    public function wrapturboNew($order)
    {
        $direction = $order['direction'] ?? null;
        $market = $order['market'] ?? null;
        $type = $order['type'] ?? null;
        $size = $order['size'] ?? null;

        return $this->turboNew($direction, $market, $type, $size);
    }
}
