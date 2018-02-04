<?php
/**
 * Created by PhpStorm.
 * User: joeldg
 * Date: 5/16/17
 * Time: 6:53 PM.
 */

namespace Bowhead\Util;

use DateTime;
use DateTimeZone;

/**
 * Class OneBroker.
 */
class OneBroker
{
    /**
     * @var mixed
     */
    protected $token;
    /**
     * @var string
     */
    protected $baseurl = 'https://1broker.com/api/v2/';

    /**
     * @var array
     */
    public $symbols = [];

    /**
     * @var string
     */
    public $symbolslist = '';

    /**
     * OneBroker constructor.
     */
    public function __construct()
    {
        $this->token = env('ONEBROKER_TOKEN');
        if (\Cache::has('ONEBROKER::symbols')) {
            $this->symbols = \Cache::get('ONEBROKER::symbols');
        } else {
            $toCache = [];
            $categories = $this->getCategories();
            $categories = $categories['body']['response'];
            foreach ($categories as $category) {
                $lists = $this->getCategories($category);
                $toCache[$category] = $lists['body']['response'];
            }
            \Cache::put('ONEBROKER::symbols', $toCache, 60 * 24 * 7);
            $this->symbols = \Cache::get('ONEBROKER::symbols');
        }
        /**
         *  we want to keep this fresh, but not be crazy about it.
         */
        $update = (rand(1, 100) == 85 ? 1 : 0);
        if (!\Cache::has('ONEBROKER::symbols::detail::BTCUSD')) {
            $update = 1; /* this is the first run kind of thing */
        }
        if ($update) {
            foreach ($this->symbols as $cat => $symbols) {
                foreach ($symbols as $arr) {
                    $this->getMarketDetails($arr['symbol']);
                }
            }
        }
    }

    /**
     * @param      $remote_tz
     * @param null $origin_tz
     *
     * @return bool|int
     */
    public function get_timezone_offset($remote_tz, $origin_tz = null)
    {
        if ($origin_tz === null) {
            if (!is_string($origin_tz = date_default_timezone_get())) {
                return false; // A UTC timestamp was returned -- bail out!
            }
        }
        $origin_dtz = new DateTimeZone($origin_tz);
        $remote_dtz = new DateTimeZone($remote_tz);
        $origin_dt = new DateTime('now', $origin_dtz);
        $remote_dt = new DateTime('now', $remote_dtz);
        $offset = $origin_dtz->getOffset($origin_dt) - $remote_dtz->getOffset($remote_dt);

        return $offset;
    }

    /**
     * @param      $dateString
     * @param null $timeZoneSource
     * @param null $timeZoneTarget
     *
     * @return string
     */
    public function changeTimeZone($dateString, $timeZoneSource = null, $timeZoneTarget = null)
    {
        // this formatting was causing issues
        $dateString = str_replace('T', ' ', $dateString);
        $dateString = str_replace('Z', '', $dateString);

        if (empty($timeZoneSource)) {
            $timeZoneSource = date_default_timezone_get();
        }
        if (empty($timeZoneTarget)) {
            $timeZoneTarget = date_default_timezone_get();
        }

        $dt = new DateTime($dateString, new DateTimeZone($timeZoneSource));
        $dt->setTimezone(new DateTimeZone($timeZoneTarget));

        return $dt->format('Y-m-d\TH:i:s\Z');
    }

    /**
     * @param $endpoint
     * @param $data
     *
     * @return array
     */
    private function getApiData($endpoint, $data)
    {
        $curl = curl_init();
        $data['token'] = $this->token;
        //$data['pretty'] = 1; /** comment out for live */
        $data['execution_time'] = 1;
        $options = [
            CURLOPT_URL            => $this->baseurl.$endpoint.'?'.http_build_query($data),
            CURLOPT_RETURNTRANSFER => true,
        ];
        curl_setopt_array($curl, $options);
        $response = curl_exec($curl);

        if ($response === false) {
            $error = curl_errno($curl);
            $message = curl_error($curl);
            curl_close($curl);
        }
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($statusCode != 200) {
            error_log('STATUS CODE', $statusCode.' '.$response);
        }

        $body = json_decode($response, 1);

        if ($body['error'] === true) {
            throw new \RuntimeException(
                sprintf('OneBroker API returned an error - %d: %s', $body['error_code'], $body['error_message'])
            );
        }

        return ['statusCode' => $statusCode, 'body' => $body];
    }

    /**
     * @param null $category
     *
     * @return array
     */
    public function getCategories($category = null)
    {
        // /market/categories.php (response[])
        // /market/list.php ? category=$category  (response[]->symbol)
        if (!empty($category)) {
            if (\Cache::has('ONEBROKER::category::detail::'.$category)) {
                $data = \Cache::get('ONEBROKER::category::detail::'.$category);
            } else {
                $data = $this->getApiData('market/list.php', ['category' => $category]);
                \Cache::put('ONEBROKER::category::detail::'.$category, $data, 60 * 24);
            }
        } else {
            if (\Cache::has('ONEBROKER::categories')) {
                $data = \Cache::get('ONEBROKER::categories');
            } else {
                $data = $this->getApiData('market/categories.php', ['category'=>$category]);
                \Cache::put('ONEBROKER::categories', $data, 60 * 24);
            }
        }

        return $data;
    }

    /**
     * @param $symbol
     *
     * @return array
     */
    public function getMarketDetails($symbol)
    {
        // market/details.php (response[]->maximum_leverage / maximum_amount
        //   overnight_charge_long_percent, overnight_charge_short_percent, decimals
        //   market_hours->timezone, open, close
        if (\Cache::has('ONEBROKER::symbols::detail::'.$symbol)) {
            return \Cache::get('ONEBROKER::symbols::detail::'.$symbol);
        } else {
            $data = $this->getApiData('market/details.php', ['symbol' => $symbol]);
            \Cache::put('ONEBROKER::symbols::detail::'.$symbol, $data, (60 * 24 * rand(14, 28) + rand(1, 15000)));

            return $data;
        }
    }

    /**
     * @return array
     */
    public function getAllSymbols()
    {
        if (\Cache::has('ONEBROKER::allSymbols')) {
            return \Cache::get('ONEBROKER::allSymbols');
        } else {
            foreach ($this->symbols as $cat => $_symbols) {
                foreach ($_symbols as $arr) {
                    $symbols[] = $arr['symbol'];
                }
            }
            \Cache::put('ONEBROKER::allSymbols', $symbols, 86400);

            return $symbols;
        }
    }

    /**
     *  simply wipe and re-build the symbol database.
     */
    public function updateSymbolsDB()
    {
        $symbols = $this->getAllSymbols();
        \DB::table('symbols')->truncate();
        foreach ($symbols as $symbol) {
            $details = $this->getMarketDetails($symbol);
            $details = $details['body']['response'];
            $details['market_hours']['open'] = explode(' ', $details['market_hours']['open']);
            $details['market_hours']['close'] = explode(' ', $details['market_hours']['close']);
            \DB::insert("
                      INSERT INTO symbols 
                      SET symbol                            = '".$details['symbol']."',
                          category                          = '".$details['category']."',
                          maximum_leverage                  = ".$details['maximum_leverage'].',
                          maximum_amount                    = '.$details['maximum_amount'].',
                          overnight_charge_long_percent     = '.$details['overnight_charge_long_percent'].',
                          overnight_charge_short_percent    = '.$details['overnight_charge_short_percent'].',
                          decimals                          = '.$details['decimals'].",
                          timezone                          = '".$details['market_hours']['timezone']."',
                          timezone_offset                   = '".$this->get_timezone_offset($details['market_hours']['timezone'], env('TIMEZONE'))."',
                          open_day                          = '".$details['market_hours']['open'][0]."',
                          open_time                         = '".$details['market_hours']['open'][1]."',
                          close_day                         = '".$details['market_hours']['close'][0]."',
                          close_time                        = '".$details['market_hours']['close'][1]."',
                          daily_break_start                 = '".$details['market_hours']['daily_break_start']."',
                          daily_break_stop                  = '".$details['market_hours']['daily_break_stop']."'
                    ");
        }
    }

    /**
     * @param $symbols
     *
     * @return array
     *
     *      We need to be able to tell if we can trade now and how long we have left to trade.
     *      Using minute ticks, we list minutes left until close and minutes left until daily break.
     *      this must take Timezones into consideration.
     *
     *      There is a log going on here to figure out where we are in a day and where we are in a week.
     *      everything is timezone converted to the symbol and are relative to current time.
     *
     *      i.e. Forex has a daily break at 17:00 to 17:15 .. On the West coast this happens at
     *           14:00 - 14:15 so ..  if it is 11:30am on the west coast the minutes until next break is
     *           150 minutes (2.5 hours)
     *
     *      This is useful to bail out of positions before an overnight break and in particular before weekly
     *      end using 'minutesUntilClose' and 'minsLeftBreak'
     *
     *      reasons: market_closed and daily_break
     *              market_closed - use: minutesUntilOpen to determine when to trade
     *              daily_break   - use: minsLeftBreak to know when trading begins again.
     */
    public function tradeCheck($symbols)
    {
        $dows = ['Sunday'=>0, 'Monday'=>1, 'Tuesday'=>2, 'Wednesday'=>3, 'Thursdday'=>4, 'Friday'=>5, 'Saturday'=>6];
        $_minOfWeek = (date('w') * 24 * 60) + (date('H') * 60) + date('i');
        $_minOfDay = (date('H') * 60) + date('i');
        $return = [];

        foreach ($symbols as $symbol) {
            $return[$symbol]['trade'] = 1;

            $details = $this->getMarketDetails($symbol);
            $details = $details['body']['response'];
            $details['market_hours']['open'] = explode(' ', $details['market_hours']['open']);
            $details['market_hours']['close'] = explode(' ', $details['market_hours']['close']);
            $tzoffset = $this->get_timezone_offset($details['market_hours']['timezone'], env('TIMEZONE'));
            $tzoffsetMin = abs(round($tzoffset / 60));

            $minOfWeek = $_minOfWeek + $tzoffsetMin;
            $minOfWeek = ($minOfWeek < 0 ? (10080 - abs($minOfWeek)) : $minOfWeek);
            $minOfWeek = ($minOfWeek > 100800 ? (abs($minOfWeek) - 10080) : $minOfWeek);
            $minOfDay = $_minOfDay + $tzoffsetMin;
            $minOfDay = ($minOfDay < 0 ? (1440 - abs($minOfDay)) : $minOfDay);
            $minOfDay = ($minOfDay > 1440 ? (abs($minOfDay) - 1400) : $minOfDay);

            $open = $dows[$details['market_hours']['open'][0]];
            $openHour = explode(':', $details['market_hours']['open'][1]);
            $close = $dows[$details['market_hours']['close'][0]];
            $closeHour = explode(':', $details['market_hours']['close'][1]);
            $open = ($open * 24 * 60) + ($openHour[0] * 60) + $openHour[1];
            $close = ($close * 24 * 60) + ($closeHour[0] * 60) + $closeHour[1];

            if ($details['category'] == 'CRYPTO') {
                continue; // CRYPTO pairs can always be traded.
            }

            if ($minOfWeek <= $open || $minOfWeek >= $close) {
                $return[$symbol]['trade'] = 0;
                $return[$symbol]['reason'] = 'market_closed';
                if ($minOfWeek <= $open) {
                    $return[$symbol]['minutesUntilOpen'] = ($open - $minOfWeek);
                } else {
                    $return[$symbol]['minutesUntilOpen'] = ((10080 - $minOfWeek) + $open);
                }
            } else {
                $return[$symbol]['minutesUntilClose'] = ($close - $minOfWeek);
                $return[$symbol]['hoursUntilClose'] = round(($close - $minOfWeek) / 60, 2);
            }

            $daily_break_start = explode(':', $details['market_hours']['daily_break_start']);
            $daily_break_stop = explode(':', $details['market_hours']['daily_break_stop']);

            /* is this an overnight break */
            if ($daily_break_start[0] > $daily_break_stop[0]) {
                $dbw_day = ($daily_break_stop[0] * 60) + $daily_break_stop[1];
                if ($minOfDay <= $dbw_day) {
                    $return[$symbol]['trade'] = 0;
                    $return[$symbol]['reason'] = 'daily_break';
                }
                $dbs_day = ($daily_break_start[0] * 60) + $daily_break_start[1];
                if ($minOfDay >= $dbs_day) {
                    $return[$symbol]['trade'] = 0;
                    $return[$symbol]['reason'] = 'daily_break';
                }
                /* no this is a short break */
            } else {
                $start = ($daily_break_start[0] * 60) + $daily_break_start[1];
                $stop = ($daily_break_stop[0] * 60) + $daily_break_stop[1];

                if ($minOfDay >= $start && $minOfDay <= $stop) {
                    $return[$symbol]['trade'] = 0;
                    $return[$symbol]['reason'] = 'daily_break';
                }
            }
            if ($return[$symbol]['trade'] == 1) {
                $dbs_day = ($daily_break_start[0] * 60) + $daily_break_start[1];
                if ($minOfDay < $dbs_day) {
                    $return[$symbol]['minsUntilBreak'] = abs($dbs_day - $minOfDay);
                    $return[$symbol]['hoursUntilBreak'] = abs(round(($dbs_day - $minOfDay) / 60, 2));
                }
            }

            if ($return[$symbol]['trade'] == 0 && $return[$symbol]['reason'] == 'daily_break') {
                $dbs_day = ($daily_break_start[0] * 60) + $daily_break_start[1];
                $return[$symbol]['minsLeftBreak'] = abs($dbs_day - $minOfDay);
                $return[$symbol]['hoursLeftBreak'] = abs(round(($dbs_day - $minOfDay) / 60, 2));
            }
        }

        return $return;
    }

    /**
     * @param $symbols
     *
     * @return array
     */
    public function getMarketQuotes($symbols)
    {
        // market/quotes.php response[]->symbol,bid,ask
        $data = $this->getApiData('market/quotes.php', ['symbols'=>$symbols]);

        return $data;
    }

    /**
     * @param     $symbol
     * @param int $resolution
     * @param     $date_start
     * @param     $date_end
     * @param     $limit
     *
     * @return array
     */
    public function getMarketHistorical($symbol, $resolution, $date_start, $date_end, $limit = 10000)
    {
        $date_start = $this->changeTimeZone($date_start, env('TIMEZONE'), 'UTC');
        $date_end = $this->changeTimeZone($date_end, env('TIMEZONE'), 'UTC');

        $cache_return = [];
        $dateString = $date_start;
        $rms = ['T'=>'', 'Z'=>''];
        $_start = strtr($date_start, $rms);
        $_end = strtr($date_end, $rms);

        $start = strtotime($_start);
        $end = strtotime($_end);
        while ($start < $end) {
            $start = ceil($start / $resolution) * $resolution;
            $datekey = date('Y-m-d\TH:i:s\Z', $start);
            $cachekey = "ONEBROKER::historical::$symbol::$resolution::$datekey";
            if (\Cache::has($cachekey)) {
                $cache_return[] = \Cache::get($cachekey);
            } else {
                $date_start = $datekey;
                break;
            }
            $start++;
        }

        // date 2016-11-02T10:28:00Z
        // market/bars.php (response[]->date,o,h,l,c)
        $data = $this->getApiData('market/bars.php', [
             'symbol'     => $symbol, 'resolution' => $resolution, 'date_start' => $date_start, 'date_end'   => $date_end, 'limit'      => $limit,
        ]);

        $data['body']['response'] += $cache_return;
        usort($data['body']['response'], function ($a, $b) {
            return $a['date'] < $b['date'];
        });

        foreach ($data['body']['response'] as $key => $dat) {
            $cachekey = "ONEBROKER::historical::$symbol::$resolution::".$data['body']['response'][$key]['date'];
            \Cache::put($cachekey, $data['body']['response'][$key], 60 * 24 * 7);
            $thisdate = $this->changeTimeZone($dat['date'], 'UTC', env('TIMEZONE'));
            $data['body']['response'][$key]['date'] = $thisdate;

            $check = \DB::table('oneBrokerHist')
                ->where('symbol', $symbol)
                ->where('buckettime', $thisdate)
                ->first();
            if (!$check) {
                $tmp = [
                     'symbol' => $symbol, 'buckettime' => $thisdate, 'o' => $dat['o'], 'h' => $dat['h'], 'l' => $dat['l'], 'c' => $dat['c'],
                ];
                \DB::table('oneBrokerHist')->insert($tmp);
            }
        }

        return $data;
    }

    /**
     * @param     $symbol
     * @param int $limit
     *
     * @return array
     */
    public function getMarketTicks($symbol, $limit = 59)
    {
        // market/ticks.php response[]->date/price/spread
        $data = $this->getApiData('market/ticks.php', ['symbol'=>$symbol, 'limit'=>$limit]);

        return $data;
    }

    /**
     * @param $user_id
     *
     * @return array
     */
    public function getSocial($user_id)
    {
        // social/profile_statistics.php
        $data = $this->getApiData('social/profile_statistics.php', ['user_id'=>$user_id]);

        return $data;
    }

    /**
     * @param     $user_id
     * @param int $offset
     * @param int $limit
     *
     * @return array
     */
    public function getSocialTrades($user_id, $offset = 0, $limit = 20)
    {
        // social/profile_trades.php
        $data = $this->getApiData('social/profile_trades.php', ['user_id'=>$user_id, 'offset'=>$offset, 'limit'=>$limit]);

        return $data;
    }

    /**
     * @return array
     */
    public function getCpu()
    {
        // /user/quota_status.php (response[])  cpu_time_left
        $data = $this->getApiData('user/quota_status.php', []);

        return $data;
    }

    /**
     * @return array
     */
    public function getOpenOrders()
    {
        ///order/open.php (response[])
        $data = $this->getApiData('order/open.php', []);

        return $data;
    }

    /**
     * @return array
     */
    public function getOpenPositions()
    {
        // position/open.php (response()[])
        $data = $this->getApiData('position/open.php', []);

        return $data;
    }

    /**
     * @return array
     */
    public function getPositionHistory()
    {
        // position/history.php (response()[])
        $data = $this->getApiData('position/history.php', []);

        return $data;
    }

    /**
     * @param $data
     *
     * @return array
     */
    public function createOrder($data)
    {
        // /order/create.php (response[]->order_id and all items from $params with date_created)
        $data = $this->getApiData('order/create.php', [
             'symbol'                            => $data['symbol'] // String
            , 'margin'                           => $data['margin'] // margin
            , 'direction'                        => $data['direction']  // long or short
            , 'leverage'                         => $data['leverage']  // desired leverage
            , 'order_type'                       => $data['order_type']  // "market", "limit" or "stop_entry"
            , 'order_type_parameter'             => $data['order_type_parameter']  //(Float) Parameter for the specified ordertype. Not required for 'Market' orders.
            , 'stop_loss'                        => $data['stop_loss']  // (float) Stop Loss for the position, once opened.
            , 'take_profit'                      => $data['take_profit']  // (float) Take Profit for the position, once opened.
            , base64_decode('cmVmZXJyYWxfaWQ=')  => base64_decode('MjE0MzQ=')  // (int)
            , 'shared'                           => 'true',  // bool true/false
        ]);

        return $data;
    }

    /**
     * @param $order_id
     *
     * @return array
     */
    public function cancelOrder($order_id)
    {
        // order/cancel.php?order_id= (response->null)
        $data = $this->getApiData('order/cancel.php', ['order_id'=>$order_id]);

        return $data;
    }

    /**
     * @param $position_id
     * @param $stop_loss
     * @param $take_profit
     * @param $trailing_stop_loss
     *
     * @return array
     */
    public function positionEdit($position_id, $stop_loss, $take_profit, $trailing_stop_loss)
    {
        // position/edit.php
        $data = $this->getApiData('position/edit.php', [
             'position_id'       => $position_id, 'stop_loss'         =>$stop_loss, 'take_profit'       =>$take_profit, 'trailing_stop_loss'=>$trailing_stop_loss,
        ]);

        return $data;
    }

    /**
     * @param $position_id
     *
     * @return array
     */
    public function positionClose($position_id)
    {
        // position/close.php
        $data = $this->getApiData('position/close.php', ['position_id'=>$position_id]);

        return $data;
    }

    /**
     * @param $position_id
     *
     * @return array
     */
    public function positionCloseCancel($position_id)
    {
        // position/close_cancel.php
        $data = $this->getApiData('position/close_cancel.php', ['position_id'=>$position_id]);

        return $data;
    }

    /**
     * @param $position_id
     *
     * @return array
     */
    public function positionSharedGet($position_id)
    {
        // position/shared/get.php
        $data = $this->getApiData('position/shared/get.php', ['position_id'=>$position_id]);

        return $data;
    }

    /**
     * @return array
     *               get balances and such
     */
    public function userDetailsGet()
    {
        $data = $this->getApiData('user/details.php', []);

        return $data;
    }

    /**
     * @return array
     *               get balances and all open orders.
     */
    public function userOverviewGet()
    {
        $data = $this->getApiData('user/overview.php', []);

        return $data;
    }
}
