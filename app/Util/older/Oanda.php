<?php

namespace Bowhead\Util;

/*
 *  Modified by joeldg to work in bowhead boilerplate
 *  SEE https://github.com/tavurth/OandaWrap for instructions on use.
 */

/*

  Copyright 2014 William Whitty
  Tavurth@gmail.com

  Licensed under the Apache License, Version 2.0 (the 'License');
  you may not use this file except in compliance with the License.
  You may obtain a copy of the License at

  http://www.apache.org/licenses/LICENSE-2.0

  Unless required by applicable law or agreed to in writing, software
  distributed under the License is distributed on an 'AS IS' BASIS,
  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
  See the License for the specific language governing permissions and
  limitations under the License.

*/

if (defined('TAVURTH_OANDAWRAP') === false) {
    define('TAVURTH_OANDAWRAP', true);

    //////////////////////////////////////////////////////////////////////////////////
    //
    //	OANDAWRAP API WRAPPER FOR OANDAS 'REST'
    //
    //	Written by William Whitty July 2014
    //	Questions, comments or bug reports?
    //
    //		Tavurth@gmail.com
    //
    //	I am in no way responsible for any of your losses incurred
    //	while trading forex.
    //	I take my trades off the table if they become losers.
    //
    //
    //	Best,
    //
    //		Will
    //
    //////////////////////////////////////////////////////////////////////////////////

    class Oanda
    {
        protected static $baseUrl;
        protected static $account;
        protected static $apiKey;
        protected static $instruments;
        protected static $socket;
        protected static $callback;
        protected static $checkSSL;

        //////////////////////////////////////////////////////////////////////////////////
        //
        //	VARIABLE DECLARATION AND HELPER FUNCTIONS
        //
        //////////////////////////////////////////////////////////////////////////////////

        public static function valid($jsonObject, $verbose = false, $message = false)
        {
            //Return boolean false if object has been corrupted or has error messages/codes included
            if (isset($jsonObject->code)) {
                if ($verbose && isset($jsonObject->message)) {
                    echo 'OandaWrap: Invalid object. '.$jsonObject->message.' ';
                }

                return false;
            }
            if (isset($jsonObject) === false || $jsonObject === false || empty($jsonObject)) {
                if ($verbose && $message) {
                    echo 'OandaWrap: Error. '.$message.' ';
                }

                return false;
            }

            return $jsonObject;
        }

        protected static function setup_account($baseUrl, $apiKey = false, $accountId = false, $checkSSL = 2)
        {
            //Generic account setup program, prints out errors in the html if incomplete
            //Set the url
            self::$baseUrl = $baseUrl;
            self::$instruments = [];
            self::$checkSSL = $checkSSL;
            //Checking our login details
            if (strpos($baseUrl, 'https') !== false || strpos($baseUrl, 'fxpractice') !== false) {

                //Check that we have specified an API key
                if (!self::valid($apiKey, true, 'Must provide API key for '.$baseUrl.' server.')) {
                    return false;
                }

                //Set the API key
                self::$apiKey = $apiKey;

                //Check that we have specified an accountId
                if (!self::valid($accountId)) {
                    if (!self::valid(($accounts = self::accounts()), true, 'No valid accounts for API key.')) {
                        return false;
                    }
                    self::$account = $accounts->accounts[0];

                //else if we passed an accountId
                } else {
                    self::$account = self::account($accountId);
                }
            }
            //Completed
            return self::nav_account(true);
        }

        public static function setup($server = false, $apiKey = false, $accountId = false, $checkSSL = 2)
        {
            //Setup our enviornment variables
            if (self::valid(self::$account)) {
                if (self::$account->accountId == $accountId) {
                    return;
                }
            }

            self::$callback = false;
            //'Live', 'Demo' or the default 'Sandbox' servers.
            switch (ucfirst(strtolower($server))) { //Set all to lowercase except the first character
            case 'Live':
                return self::setup_account('https://api-fxtrade.oanda.com/v1/', $apiKey, $accountId, $checkSSL);
            case 'Demo':
                return self::setup_account('https://api-fxpractice.oanda.com/v1/', $apiKey, $accountId, $checkSSL);
            case 'Sandbox':
                return self::setup_account('http://api-sandbox.oanda.com/v1/');
            default:
                echo 'User must specify: "Live", "Demo", or "Sandbox" server for OandaWrap setup.';

                return false;
            }
        }

        protected static function index()
        {
            //Return a formatted string for more concise code
            if (self::valid(self::$account)) {
                return 'accounts/'.self::$account->accountId.'/';
            }

            return 'accounts/0/';
        }

        protected static function position_index()
        {
            //Return a formatted string for more concise code
            return self::index().'positions/';
        }

        protected static function trade_index()
        {
            //Return a formatted string for more concise code
            return self::index().'trades/';
        }

        protected static function order_index()
        {
            //Return a formatted string for more concise code
            return self::index().'orders';
        }

        protected static function transaction_index()
        {
            //Return a formatted string for more concise code
            return self::index().'transactions/';
        }

        //////////////////////////////////////////////////////////////////////////////////
        //
        //	DIRECT NETWORK ACCESS
        //
        //////////////////////////////////////////////////////////////////////////////////

        protected static function data_decode($data)
        {
            //Return decoded data
            if (!self::valid($data)) {
                //Return a stdObj with failure codes and message
                $failure = new stdClass();
                $failure->code = -1;
                $failure->message = 'OandaWrap throws curl error: '.curl_error(self::$socket);

                return $failure;
            }

            return json_decode(($decoded = @gzinflate(substr($data, 10, -8))) ? $decoded : $data);
        }

        protected static function authenticate($curl)
        {
            //Authenticate our curl object
            $headers = ['X-Accept-Datetime-Format: UNIX',			//Milliseconds since epoch
                             'Accept-Encoding: gzip, deflate',		//Compress data
                             'Connection: Keep-Alive', ];				//Persistant http connection
            if (isset(self::$apiKey)) {    								//Add our login hash
                array_push($headers, 'Authorization: Bearer '.self::$apiKey);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, self::$checkSSL);			//Verify Oanda
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, self::$checkSSL);			//Verify Me
            }
            //Set the sockets headers
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }

        protected static function configure($curl)
        {
            //Configure default connection settings
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);				//We want the data returned as a variable
            curl_setopt($curl, CURLOPT_TIMEOUT, 10);						//Maximum wait before timeout
            self::authenticate($curl);									//Authenticate our socket
            return $curl;
        }

        protected static function socket_new()
        {
            return self::configure($socket = curl_init());
        }

        protected static function socket()
        {
            //Return our active socket for reuse
            if (!self::valid(self::$socket)) {
                self::$socket = self::socket_new();
            }

            return self::$socket;
        }

        protected static function get($index, $queryData = false)
        {
            //Send a GET request to Oanda
            $queryData = ($queryData ? $queryData : []);
            $curl = self::socket();

            curl_setopt($curl, CURLOPT_HTTPGET, 1);
            curl_setopt($curl, CURLOPT_URL, //Url setup
                        self::$baseUrl.$index.($queryData ? '?'.http_build_query($queryData) : ''));
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');   //GET request setup
            return self::data_decode(curl_exec($curl));         //Launch and store decrypted data
        }

        protected static function post($index, $queryData)
        {
            //Send a POST request to Oanda
            $curl = self::socket();

            curl_setopt($curl, CURLOPT_URL, self::$baseUrl.$index);       //Url setup
            curl_setopt($curl, CURLOPT_POST, 1);                            //Tell curl we want to POST
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');              //POST request setup
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($queryData));  //Include the POST data
            return self::data_decode(curl_exec($curl)); 		//Launch and return decrypted data
        }

        protected static function patch($index, $queryData)
        {
            //Send a PATCH request to Oanda
            $curl = self::socket();

            curl_setopt($curl, CURLOPT_URL, self::$baseUrl.$index);              //Url setup
            curl_setopt($curl, CURLOPT_POST, 1);                                   //Tell curl we want to POST
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PATCH');                    //PATCH request setup
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($queryData));  //Include the POST data
            return self::data_decode(curl_exec($curl));                            //Launch and return decrypted data
        }

        protected static function delete($index)
        {
            //Send a DELETE request to Oanda
            $curl = self::socket();

            curl_setopt($curl, CURLOPT_URL, self::$baseUrl.$index);		//Url setup
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');			//DELETE request setup
            return self::data_decode(curl_exec($curl)); 		            //Launch and return decrypted data
        }

        private static function stream_callback($curl, $str)
        {
            //Callback that then calls your function to process streaming data

            // Decode the data and check
            if (($decoded = @json_decode($str)) != null) {
                // Call the users callback
                if (call_user_func(self::$callback, $decoded) != null) {
                    return false;
                }
            } // Quit the stream when user returns value

            // Continue the stream
            return strlen($str);
        }

        private static function stream_url($type)
        {
            //Find the base of the url
            return str_replace('api', 'stream', self::$baseUrl).$type.'?';
        }

        private static function stream_setup($callback, $streamUrl)
        {
            //Set the internal callback function
            self::$callback = $callback;

            //Authenticate the socket to Oanda
            self::authenticate(($streamHandle = curl_init()));

            //Setup the stream
            curl_setopt($streamHandle, CURLOPT_URL, $streamUrl);

            //Our callback, called for every new data packet
            curl_setopt($streamHandle, CURLOPT_WRITEFUNCTION, 'self::stream_callback');

            return $streamHandle;
        }

        private static function event_stream($callback, $options = false)
        {
            //Load the account from setup
            if (self::valid($account = self::nav_account(true))) {

                // Check that we passed at least one valid account
                if (!self::valid($options, true, 'Must provide array of AccountIds for events streaming.')) {
                    return false;
                }

                // Return a curl handle to the new stream
                return self::stream_setup($callback, self::stream_url('events').'accountIds='.implode(',', $options));
            }
        }

        private static function quote_stream($callback, $options = false)
        {
            //Load the account from setup
            if (self::valid($account = self::nav_account(true))) {

                // Check that we passed at least one valid account
                if (!self::valid($options, true, 'Must provide array of currency pairs for quote streaming.')) {
                    return false;
                }

                // Return a curl handle to the new stream
                return self::stream_setup($callback, self::stream_url('prices').'accountId='.$account->accountId.'&instruments='.implode(',', $options));
            }
        }

        public function stream_exec($multiHandle)
        {
            $running = 1;
            while ($running > 0) {
                curl_multi_exec($multiHandle, $running);
                curl_multi_select($multiHandle);
            }
        }

        public static function stream($callback, $quotes = false, $accounts = false)
        {
            //Open a stream to Oanda
            //	$callback = function ($jsonObject) { /* { YOUR CODE } */;  }
            //
            // Quotes Example:
            //	OandaWrap::stream(function ($event) { var_dump($event); }, array('EUR_USD'), FALSE);
            //
            // Events Example:
            //	OandaWrap::stream(function ($event) { var_dump($event); }, FALSE, array('12345'));
            //
            //
            // Events Example:
            //	OandaWrap::stream(function ($event) { var_dump($event); }, array('EUR_USD'), array('12345'));
            //Notes:
            //	Returning any value from the callback function (true or false) will exit the stream

            $eventStream = false;
            $quoteStream = false;

            // Return false if no parameters were passed
            if (!$quotes && !$accounts) {
                return false;
            }

            // Create the multi curl base
            $multiHandle = curl_multi_init();

            // Add the quote stream
            if ($quotes !== false && !empty($quotes)) {
                if (($quoteStream = self::quote_stream($callback, $quotes))) {
                    curl_multi_add_handle($multiHandle, $quoteStream);
                }
            }

            // Add the event stream
            if ($accounts !== false && !empty($accounts)) {
                if (($eventStream = self::event_stream($callback, $accounts))) {
                    curl_multi_add_handle($multiHandle, $eventStream);
                }
            }

            self::stream_exec($multiHandle);

            // Cleanup
            if ($eventStream) {
                curl_multi_remove_handle($multiHandle, $eventStream);
            }
            if ($quoteStream) {
                curl_multi_remove_handle($multiHandle, $quoteStream);
            }
            curl_multi_close($multiHandle);
        }

        //////////////////////////////////////////////////////////////////////////////////
        //
        //	ACCOUNT WRAPPERS
        //
        //////////////////////////////////////////////////////////////////////////////////

        public static function account($accountId)
        {
            //Return the information for $accountId
            return self::get('accounts/'.$accountId);
        }

        public static function accounts()
        {
            //Return a jsonObject of the accounts for $username
            return self::get('accounts');
        }

        public static function account_id($accountName, $uName)
        {
            //Return the accountId for $accountName
            return self::valid($account = self::account_named($accountName, $uName)) ? $account->accountId : $account;
        }

        public static function account_named($accountName, $uName)
        {
            //Return the information for $accountName

            if (!self::valid($accounts = self::accounts($uName))) {
                return $accounts;
            }

            foreach ($accounts->accounts as $account) {
                if ($account->accountName == $accountName) {
                    return $account;
                }
            }

            return false;
        }

        //////////////////////////////////////////////////////////////////////////////////
        //
        //	INSTRUMENT WRAPPERS
        //
        //////////////////////////////////////////////////////////////////////////////////

        public static function instruments()
        {
            //Return a list of tradeable instruments for $accountId
            if (!self::valid(self::$account)) {
                return self::$account;
            }

            if (empty(self::$instruments)) {
                self::$instruments = self::get('instruments', ['accountId' => self::$account->accountId]);
            }

            return self::$instruments;
        }

        public static function instrument($pair)
        {
            //Return instrument for named $pair

            if (!self::valid($instruments = self::instruments())) {
                return $instruments;
            }

            foreach ($instruments->instruments as $instrument) {
                if ($pair == $instrument->instrument) {
                    return $instrument;
                }
            }

            return false;
        }

        public static function instrument_pairs($currency)
        {
            //Return instruments for that correspond to $currency

            if (!self::valid($instruments = self::instruments())) {
                return $instruments;
            }

            $result = (object) ['instruments' => []];
            foreach ($instruments->instruments as $instrument) {
                if (strpos($instrument->instrument, $currency)) {
                    $result->instruments[] = $instrument->instrument;
                }
            }

            return $result;
        }

        public static function instrument_name($home, $away)
        {
            //Return a proper instrument name for two currencies
            //Example: OandaWrap::instrument_name('AUD', 'CHF') returns 'AUD_CHF'
            //Example: OandaWrap::instrument_name('USD', 'EUR') returns 'EUR_USD'
            if (self::instrument($home.'_'.$away)) {
                return $home.'_'.$away;
            }
            if (self::instrument($away.'_'.$home)) {
                return $away.'_'.$home;
            }

            return 'Invalid_instrument__'.$home.'/'.$away;
        }

        public static function instrument_split($pair)
        {
            //Split an instrument into two currencies and return an array of them both
            $currencies = [];
            $dividerPos = strpos($pair, '_');
            //Failire
            if ($dividerPos === false) {
                return false;
            }
            //Building array
            array_push($currencies, substr($pair, 0, $dividerPos));
            array_push($currencies, substr($pair, $dividerPos + 1));

            return $currencies;
        }

        public static function instrument_pip($pair)
        {
            //Return a floating point number declaring the pip size of $pair
            return self::valid(($instrument = self::instrument($pair)), true) ? $instrument->pip : $instrument;
        }

        //////////////////////////////////////////////////////////////////////////////////
        //
        //	CALCULATOR FUNCTIONS
        //
        //////////////////////////////////////////////////////////////////////////////////

        public static function convert($pairHome, $pairAway, $amount)
        {
            //Convert $amount of $pairHome to $pairAway
            if (!self::valid($pair = self::instrument_name($pairHome, $pairAway))) {
                return $pair;
            }

            if (!self::valid($price = self::price($pair))) {
                return $price;
            }

            //Use the $baseIndex currency of $pair (AUD_JPY = Aud or Jpy)
            $reverse = (strpos($pair, $pairHome) > strpos($pair, '_') ? false : true);

            //Which way to convert
            return $reverse ? $amount * $price->ask : $amount / $price->ask;
        }

        public static function convert_pair($pair, $amount, $home)
        {
            //Convert $amount of $pair from $home
            //	i.e. OandaWrap::convert_pair('EUR_USD', 500, 'EUR'); Converts 500 EUR to USD
            //	i.e. OandaWrap::convert_pair('EUR_USD', 500, 'USD'); Converts 500 USD to EUR
            if (!self::valid($price = self::price($pair))) {
                return $price;
            }

            $pairNames = self::instrument_split($pair);
            $homeFirst = $home == $pairNames[0] ? true : false;

            return $homeFirst ?
                    self::convert($pairNames[0], $pairNames[1], $amount) :
                    self::convert($pairNames[1], $pairNames[0], $amount);
        }

        public static function calc_pips($pair, $open, $close)
        {
            //Return the pip difference between prices $open and $close for $pair
            if (!self::valid($instrument = self::instrument_pip($pair))) {
                return $instrument;
            }

            return round(($open - $close) / $instrument, 2);
        }

        public static function calc_pip_price($pair, $size, $side = 1)
        {
            //Return the cost of a single pip of $pair when $size is used
            return (self::valid($price = self::price(self::nav_instrument_name($pair, 1)))) ?
                                       (self::instrument_pip($pair) / ($side ? $price->bid : $price->ask)) * $size : $price;
        }

        //////////////////////////////////////////////////////////////////////////////////
        //
        //	NAV (NET ACCOUNT VALUE) WRAPPERS
        //
        //////////////////////////////////////////////////////////////////////////////////

        public static function nav_account_set($accountId)
        {
            //Set our environment variable $account
            return self::valid(self::$account = self::account($accountId));
        }

        public static function nav_account($verbose = false)
        {
            //Return our environment variable account
            return isset(self::$account->message) ? false : self::$account;
        }

        public static function nav_instrument_name($pair, $index = 0)
        {
            //Return the instrument name used to convert currency for the NAV
            if (!self::valid(self::$account)) {
                return self::$account;
            }

            //Split the $pair
            if (!self::valid($splitName = self::instrument_split($pair))) {
                return $splitName;
            }

            //Choose the correct pair for the nav
            if ($splitName[$index] == self::$account->accountCurrency) {
                $index = ($index == 1 ? 0 : 1);
            }

            //Find the new instrument for the nav with $pair
            return self::instrument_name(self::$account->accountCurrency, $splitName[$index]);
        }

        public static function nav_size_percent($pair, $percent, $leverage = 50)
        {
            //Return the value of a percentage of the NAV (Net account value)

            //Validate account details
            if (!self::valid(self::$account)) {
                return self::$account;
            }

            //Validate pair name
            if (!self::valid($name = self::nav_instrument_name($pair))) {
                return $name;
            }

            //Calculate the percentage balance to use in the trade
            $percent = self::$account->balance * ($percent / 100);

            //Convert the size to the trade currency
            if (!self::valid($baseSize = self::convert_pair($name, $percent, self::$account->accountCurrency))) {
                return $baseSize;
            }

            //Calculate and return the leveraged size
            return ceil($baseSize * $leverage);
        }

        public static function nav_size_percent_per_pip($pair, $riskPerPip, $leverage = 50)
        {
            //Return the size for $pair that risks $riskPerPip every pip

            //Calculate maximum size @ $leverage
            if (!self::valid($maxSize = self::nav_size_percent($pair, 100, $leverage))) {
                return $maxSize;
            }

            //@ maximum 50:1 leverage, risk is 0.5% per pip
            $baseSize = ($riskPerPip / 0.5) * $maxSize;

            //Calculate our leveraged size
            return floor(($leverage / 50) * $baseSize);
        }

        public static function nav_pnl($dollarValue = false)
        {
            //Return the pnl for account, if $dollarValue is set TRUE, return in base currency, else as %.

            //Check for valid account
            if (!self::valid(self::$account)) {
                return self::$account;
            }

            if (self::$account->balance == 0) {
                return 0.00;
            }

            //Percentage
            if ($dollarValue === false) {
                return round((self::$account->unrealizedPl / self::$account->balance) * 100, 2);
            }

            //Default
            return self::$account->unrealizedPl;
        }

        //////////////////////////////////////////////////////////////////////////////////
        //
        //	TRANSACTION WRAPPERS
        //
        //////////////////////////////////////////////////////////////////////////////////

        public static function transaction($transactionId)
        {
            //Get information on a single transaction
            return self::get(self::transaction_index().$transactionId);
        }

        public static function transactions($number = 50, $pair = 'all')
        {
            //Return an object with all transactions (max 50)
            return self::get(self::transaction_index(), ['count' => $number, 'instrument' => $pair]);
        }

        public static function transactions_types($types, $number = 50, $pair = 'all')
        {
            //Return a jsonObject with all transactions conforming to one of $types which is an array of strings

            if (!self::valid($transactions = self::transactions())) {
                return $transactions;
            }

            $result = (object) ['transactions' => []];
            foreach ($transactions->transactions as $transaction) {
                //If the type is valid
                if (in_array($transaction->type, $types)) {
                    //Buffer it in the object
                    $result->transactions[] = $transaction;
                }
            }
            //Return sucess object
            return $result;
        }

        public static function transactions_type($type, $number = 50, $pair = 'all')
        {
            //Return up to 50 transactions of $type
            return self::transactions_types([$type], $number, $pair);
        }

        //////////////////////////////////////////////////////////////////////////////////
        //
        //	! LIVE FUNCTIONS !
        //
        //////////////////////////////////////////////////////////////////////////////////

        //////////////////////////////////////////////////////////////////////////////////
        //
        // TIME FUNCTIONS
        //
        //////////////////////////////////////////////////////////////////////////////////

        public static function time_seconds($time)
        {
            //Convert oanda time from microseconds to seconds
            return floor($time / 1000000);
        }

        public static function gran_seconds($gran)
        {
            //Return a the number of seconds per Oandas 'granularity'
            switch (strtoupper($gran)) {
            case 'S5': return 5;
            case 'S10': return 10;
            case 'S15': return 15;
            case 'S30': return 30;
            case 'M1': return 60;
            case 'M2': return 2 * 60;
            case 'M3': return 3 * 60;
            case 'M4': return 4 * 60;
            case 'M5': return 5 * 60;
            case 'M10': return 10 * 60;
            case 'M15': return 15 * 60;
            case 'M30': return 30 * 60;
            case 'H1': return 60 * 60;
            case 'H2': return 2 * 60 * 60;
            case 'H3': return 3 * 60 * 60;
            case 'H4': return 4 * 60 * 60;
            case 'H6': return 6 * 60 * 60;
            case 'H8': return 8 * 60 * 60;
            case 'H12': return 12 * 60 * 60;
            case 'D': return 24 * 60 * 60;
            case 'W': return 7 * 24 * 60 * 60;
            case 'M': return (365 * 24 * 60 * 60) / 12;
            }
        }

        public static function expiry($seconds = 5)
        {
            //Return the Oanda compatible timestamp of time() + $seconds
            return time() + $seconds;
        }

        public static function expiry_min($minutes = 5)
        {
            //Return the Oanda compatible timestamo of time() + $minutes
            return self::expiry($minutes * 60);
        }

        public static function expiry_hour($hours = 1)
        {
            //Return the Oanda compatible timestamp of time() + $hours
            return self::expiry_min($hours * 60);
        }

        public static function expiry_day($days = 1)
        {
            //Return the Oanda compatible timestamp of time() + $days
            return self::expiry_hour($days * 24);
        }

        //////////////////////////////////////////////////////////////////////////////////
        //
        //	BIFUNCTIONAL MODIFICATION WRAPPERS
        //
        //////////////////////////////////////////////////////////////////////////////////

        //$type in all cases for bidirectional is either 'order' or 'trade'

        protected static function set_($type, $id, $args)
        {
            //Macro function for setting attributes of both orders and trades
            switch ($type) {
            case 'order':
                return self::order_set($id, $args);
            case 'trade':
                return self::trade_set($id, $args);
            }
        }

        public static function set_stop($type, $id, $price)
        {
            //Set the stopLoss of an order or trade
            return self::set_($type, $id, ['stopLoss' => $price]);
        }

        public static function set_tp($type, $id, $price)
        {
            //Set the takeProfit of an order or trade
            return self::set_($type, $id, ['takeProfit' => $price]);
        }

        public static function set_trailing_stop($type, $id, $distance)
        {
            //Set the trailingStop of an order or trade
            return self::set_($type, $id, ['trailingStop' => $distance]);
        }

        //////////////////////////////////////////////////////////////////////////////////
        //
        //	ORDER WRAPPERS
        //
        //////////////////////////////////////////////////////////////////////////////////

        public static function order($orderId)
        {
            //Return an object with the information about $orderId
            return self::get(self::order_index().'/'.$orderId);
        }

        public static function order_pair($pair, $number = 50)
        {
            //Get an object with all the orders for $pair
            return self::get(self::order_index(), ['instrument' => $pair, 'count' => $number]);
        }

        public static function order_open($side, $units, $pair, $type, $price = false, $expiry = false, $rest = false)
        {
            //Open a new order

            //failure to provide expiry and price to limit or stop orders?
            if ($type !== 'market' && ($price === false || $expiry === false)) {
                return false;
            }

            //Setup options
            $orderOptions = [
                'instrument' => $pair,
                'units'      => $units,
                'side'       => $side,
                'type'       => $type,
            ];

            if ($price) {
                $orderOptions['price'] = $price;
            }
            if ($expiry) {
                $orderOptions['expiry'] = $expiry;
            }

            if (is_array($rest)) {
                foreach ($rest as $key => $value) {
                    $orderOptions[$key] = $value;
                }
            }

            return self::post(self::order_index(), $orderOptions);
        }

        public static function order_close($orderId)
        {
            //Close an order by Id
            return self::delete(self::order_index().'/'.$orderId);
        }

        public static function order_close_all($pair)
        {
            //Close all orders in $pair

            if (!self::valid($orders = self::order_pair($pair))) {
                return $orders;
            }

            $result = (object) ['orders' => []];
            foreach ($orders->orders as $order) {
                if (isset($order->id)) {
                    $result->orders[] = self::order_close($order->id);
                }
            }

            return $result;
        }

        //////////////////////////////////////////////////////////////////////////////////
        //
        //	ORDER MODIFICATION WRAPPERS
        //
        //////////////////////////////////////////////////////////////////////////////////

        public static function order_set($orderId, $options)
        {
            //Modify the parameters of an order
            return self::patch(self::order_index().'/'.$orderId, $options);
        }

        public static function order_set_stop($id, $price)
        {
            //Set the stopLoss of an order
            return self::set_stop('order', $id, $price);
        }

        public static function order_set_tp($id, $price)
        {
            //Set the takeProfit of an order
            return self::set_tp('order', $id, $price);
        }

        public static function order_set_trailing_stop($id, $distance)
        {
            //Set the trailingStop of an order
            return self::set_trailing_stop('order', $id, $distance);
        }

        public static function order_set_expiry($id, $time)
        {
            //Set the expiry of an order
            return self::set_('order', $id, ['expiry' => $time]);
        }

        public static function order_set_units($id, $units)
        {
            //Set the units of an order
            return self::set_('order', $id, ['units' => $units]);
        }

        public static function order_set_all($pair, $options)
        {
            //Modify all orders on $pair

            if (!self::valid($orders = self::order_pair($pair))) {
                return $orders;
            }

            $result = (object) ['orders' => []];
            foreach ($orders->orders as $order) {
                if (isset($order->id)) {
                    $result->orders[] = self::set_('order', $order->id, $options);
                }
            }

            return $result;
        }

        //////////////////////////////////////////////////////////////////////////////////
        //
        //	TRADE WRAPPERS
        //
        //////////////////////////////////////////////////////////////////////////////////

        public static function trade($tradeId)
        {
            //Return an object containing information on a single pair
            return self::get(self::trade_index().$tradeId);
        }

        public static function trade_pair($pair, $number = 50)
        {
            //Return an object with all the trades on $pair
            return self::get(self::trade_index(), ['instrument' => $pair, 'count' => $number]);
        }

        public static function trade_close($tradeId)
        {
            //Close trade referenced by $tradeId
            return self::delete(self::trade_index().$tradeId);
        }

        public static function trade_close_all($pair)
        {
            //Close all trades on $pair
            if (!self::valid($trades = self::trade_pair($pair))) {
                return $trades;
            }

            $result = (object) ['trades' => []];
            foreach ($trades->trades as $trade) {
                if (isset($trade->id)) {
                    $result->trades[] = self::trade_close($trade->id);
                }
            }

            return $result;
        }

        //////////////////////////////////////////////////////////////////////////////////
        //
        //	TRADE MODIFICATION WRAPPERS
        //
        //////////////////////////////////////////////////////////////////////////////////

        public static function trade_set($tradeId, $options)
        {
            //Modify attributes of a trade referenced by $tradeId
            return self::patch(self::trade_index().$tradeId, $options);
        }

        public static function trade_set_stop($id, $price)
        {
            //Set the stopLoss of a trade
            return self::set_stop('trade', $id, $price);
        }

        public static function trade_set_tp($id, $price)
        {
            //Set the takeProfit of a trade
            return self::set_tp('trade', $id, $price);
        }

        public static function trade_set_trailing_stop($id, $distance)
        {
            //Set the trailingStop of a trade
            return self::set_trailing_stop('trade', $id, $distance);
        }

        public static function trade_set_all($pair, $options)
        {
            //Modify all trades on $pair

            if (!self::valid($trades = self::trade_pair($pair))) {
                return $trades;
            }

            $result = (object) ['trades' => []];
            foreach ($trades->trades as $trade) {
                if (isset($trade->id)) {
                    $result->trades[] = self::set_('trade', $trade->id, $options);
                }
            }

            return $result;
        }

        //////////////////////////////////////////////////////////////////////////////////
        //
        //	POSITION WRAPPERS
        //
        //////////////////////////////////////////////////////////////////////////////////

        public static function position($pair)
        {
            //Return an object with the information for a single $pairs position
            return self::get(self::position_index().$pair);
        }

        public static function position_pnl_pips($pair)
        {
            //Return an int() of the calculated profit or loss for $pair in pips

            //Check position validity
            if (!self::valid($position = self::position($pair))) {
                return $position;
            }

            //Buy back across the spread
            $price = $position->side == 'buy' ? self::price($pair)->bid : self::price($pair)->ask;

            //Calculate and return the pips
            return self::calc_pips($pair, $position->avgPrice, $price);
        }

        public static function positions()
        {
            //Return an object with all the positions for the account
            return self::get(self::position_index());
        }

        public static function position_close($pair)
        {
            //Close the position for $pair
            return self::delete(self::position_index().$pair);
        }

        //////////////////////////////////////////////////////////////////////////////////
        //
        //	BIDIRECTIONAL WRAPPERS
        //
        //////////////////////////////////////////////////////////////////////////////////

        public static function market($side, $units, $pair, $rest = false)
        {
            //Open a new @ market order
            return self::order_open($side, $units, $pair, 'market', false, false, $rest);
        }

        public static function limit($side, $units, $pair, $price, $expiry, $rest = false)
        {
            //Open a new limit order
            return self::order_open($side, $units, $pair, 'limit', $price, $expiry, $rest);
        }

        public static function stop($side, $units, $pair, $price, $expiry, $rest = false)
        {
            //Open a new stop order
            return self::order_open($side, $units, $pair, 'stop', $price, $expiry, $rest);
        }

        public static function mit($side, $units, $pair, $price, $expiry, $rest = false)
        {
            //Open a new marketIfTouched order
            return self::order_open($side, $units, $pair, 'marketIfTouched', $price, $expiry, $rest);
        }

        //////////////////////////////////////////////////////////////////////////////////
        //
        //	BUYING WRAPPERS
        //
        //////////////////////////////////////////////////////////////////////////////////

        public static function buy_market($units, $pair, $rest = false)
        {
            //Buy @ market
            return self::market('buy', $units, $pair, $rest);
        }

        public static function buy_limit($units, $pair, $price, $expiry, $rest = false)
        {
            //Buy limit with expiry
            return self::limit('buy', $units, $pair, $price, $expiry, $rest);
        }

        public static function buy_stop($units, $pair, $price, $expiry, $rest = false)
        {
            //Buy stop with expiry
            return self::stop('buy', $units, $pair, $price, $expiry, $rest);
        }

        public static function buy_mit($units, $pair, $price, $expiry, $rest = false)
        {
            //Buy marketIfTouched with expiry
            return self::mit('buy', $units, $pair, $price, $expiry, $rest);
        }

        public static function buy_bullish($pair, $risk, $stop, $leverage = 50)
        {
            //Macro: Buy $pair and limit size to equal %NAV loss over $stop pips. Then set stopLoss

            //Retrieve current price
            if (!self::valid($price = self::price($pair))) {
                return $price;
            }

            //Find the correct size so that $risk is divided by $pips
            if (!self::valid($size = self::nav_size_percent_per_pip($pair, ($risk / $stop)))) {
                return $size;
            }

            if (!self::valid($newTrade = self::buy_market($size, $pair)) && isset($newTrade->tradeId)) {
                return $newTrade;
            }

            //Set the stoploss
            return self::trade_set_stop($newTrade->tradeId, $price->ask + (self::instrument_pip($pair) * $stop));
        }

        //////////////////////////////////////////////////////////////////////////////////
        //
        //	SELLING WRAPPERS
        //
        //////////////////////////////////////////////////////////////////////////////////

        public static function sell_market($units, $pair, $rest = false)
        {
            //Sell @ market
            return self::market('sell', $units, $pair, $rest);
        }

        public static function sell_limit($units, $pair, $price, $expiry, $rest = false)
        {
            //Sell limit with expiry
            return self::limit('sell', $units, $pair, $price, $expiry, $rest);
        }

        public static function sell_stop($units, $pair, $price, $expiry, $rest = false)
        {
            //Sell stop with expiry
            return self::stop('sell', $units, $pair, $price, $expiry, $rest);
        }

        public static function sell_mit($units, $pair, $price, $expiry, $rest = false)
        {
            //Sell marketIfTouched with expiry
            return self::mit('sell', $units, $pair, $price, $expiry, $rest);
        }

        public static function sell_bearish($pair, $risk, $stop, $leverage = 50)
        {
            //Macro: Sell $pair and limit size to equal %NAV loss over $stop pips. Then set stopLoss

            //Retrieve current price
            if (!self::valid($price = self::price($pair))) {
                return $price;
            }

            //Find the correct size so that $risk is divided by $pips
            if (!self::valid($size = self::nav_size_percent_per_pip($pair, ($risk / $stop)))) {
                return $size;
            }

            if (!self::valid($newTrade = self::sell_market($size, $pair)) && isset($newTrade->tradeId)) {
                return $newTrade;
            }

            //Set the stoploss
            return self::trade_set_stop($newTrade->tradeId, $price->bid - (self::instrument_pip($pair) * $stop));
        }

        //////////////////////////////////////////////////////////////////////////////////
        //
        //	PRICE WRAPPERS
        //
        //////////////////////////////////////////////////////////////////////////////////

        protected static function candle_time_to_seconds($candle)
        {
            //Convert the timing of $candle from microseconds to seconds
            $candle->time = self::time_seconds($candle->time);

            return $candle;
        }

        protected static function candles_times_to_seconds($candles)
        {
            //Convert the times of $candles from microseconds to seconds
            if (self::valid($candles)) {
                $candles->candles = array_map('self::candle_time_to_seconds', $candles->candles);
            }

            return $candles;
        }

        public static function price($pair)
        {
            //Wrapper, return the current price of '$pair'
            return (self::valid($prices = self::prices([$pair]))) ? $prices->prices[0] : $prices;
        }

        public static function prices($pairs)
        {
            //Return a jsonObject {prices} for {$pairs}
            return self::get('prices', ['instruments' => implode(',', $pairs)]);
        }

        public static function price_time($pair, $date)
        {
            //Wrapper, return the price of '$pair' at $date which is a string such as "20:15 5th november 2012"
            return (self::valid($candles = self::candles_time($pair, 'S5', ($time = strtotime($date)), $time + 10))) ?
                                         $candles->candles[0] : $candles;
        }

        public static function candles($pair, $gran, $rest = null)
        {
            //Return a number of candles for '$pair'

            //Defaults for $rest
            $rest = is_array($rest) ? $rest : ['count' => 1];

            //If we passed an array with no start time, then choose one candle
            if (!isset($rest['count']) && !isset($rest['start'])) {
                $rest['count'] = 1;
            }

            //Setup stamdard options
            $candleOptions = [
                'candleFormat'  => 'midpoint',
                'instrument'    => $pair,
                'granularity'   => strtoupper($gran),
            ];

            //Check for rest processing
            if (is_array($rest)) {
                foreach ($rest as $key => $value) {
                    $candleOptions[$key] = $value;
                }
            }

            //Check the object
            return (self::valid($candles = self::get('candles', $candleOptions))) ?
                                         self::candles_times_to_seconds($candles) : $candles;
        }

        public static function candles_time($pair, $gran, $start, $end)
        {
            //Return candles for '$pair' between $start and $end
            return self::candles($pair, $gran, ['start' => $start, 'end' => $end]);
        }

        public static function candles_count($pair, $gran, $count)
        {
            //Return $count of the previous candles for '$pair'
            return self::candles($pair, $gran, ['count' => $count]);
        }
    }
}
