<?php
# this is taken from https://github.com/coinables/Bitfinex-API-PHP/blob/features/finex.php
#
# TODO redo this and write a proper wrapper.
# I am mostly including this as an API KEY verification, however this can be used for creating a
# bot within this system.
#

namespace Bowhead\Util;

/**
 * Class Bitfinex
 * @package Bowhead\Util
 *
 *              Streaming is a different animal and done via the command.
 */
class Bitfinex{
  private $apikey;
  private $secret;
  private $url = "https://api.bitfinex.com";

  public function __construct($apikey, $secret)
  {
     $this->apikey = $apikey;
     $this->secret = $secret;
  }

  public function new_order_wrap($order)
  {
      return $this->new_order($order['symbol'], $order['amt'], $order['price'], $order['side'], $order['type']);
  }

   public function new_order($symbol, $amount, $price, $side, $type)
   {
      $request = "/v1/order/new";
      $data = array(
         "request" => $request,
         "symbol" => $symbol,
         "amount" => $amount,
         "price" => $price,
         "exchange" => "bitfinex",
         "side" => $side,
         "type" => $type
      );
      return $this->hash_request($data);
   }
   /*
   response
   {
  "id":448364249,
  "symbol":"btcusd",
  "exchange":"bitfinex",
  "price":"0.01",
  "avg_execution_price":"0.0",
  "side":"buy",
  "type":"exchange limit",
  "timestamp":"1444272165.252370982",
  "is_live":true,
  "is_cancelled":false,
  "is_hidden":false,
  "was_forced":false,
  "original_amount":"0.01",
  "remaining_amount":"0.01",
  "executed_amount":"0.0",
  "order_id":448364249
   }
   */
   
   public function cancel_order($order_id)
   {
      $request = "/v1/order/cancel";
	  $data = array(
	     "request" => $request,
	     "order_id" => (int)$order_id
	  );
	  return $this->hash_request($data);
   }
   
   public function cancel_all()
   {
   $request = "/v1/order/cancel/all";
   $data = array(
      "request" => $request
   );
   return $this->hash_request($data);
   }
   
   public function account_info()
   {
   $request = "/v1/account_infos";
   $data = array(
      "request" => $request
   );
   return $this->hash_request($data);
   }
   /*
   response
   [{
  "maker_fees":"0.1",
  "taker_fees":"0.2",
    "fees":[{
    "pairs":"BTC",
    "maker_fees":"0.1",
    "taker_fees":"0.2"
   },{
    "pairs":"LTC",
    "maker_fees":"0.1",
    "taker_fees":"0.2"
   },
   {
    "pairs":"DRK",
    "maker_fees":"0.1",
    "taker_fees":"0.2"
     }]
   }]
   */

   public function deposit($method, $wallet, $renew)
   {
   $request = "/v1/deposit/new";
   $data = array(
      "request" => $request,
      "method" => $method,
      "wallet_name" => $wallet,
      "renew" => $renew
   );
   return $this->hash_request($data);
   }
   /*
   depost generates a BTC address to deposit funds into bitfinex
   example: deposit("bitcoin", "trading", $renew);
   $renew will generate a new fresh deposit address if set to 1, default is 0
   //response
   {
  "result":"success",
  "method":"bitcoin",
  "currency":"BTC",
  "address":"3FdY9coNq47MLiKhG2FLtKzdaXS3hZpSo4"
   }
   */
   
   public function positions()
   {
   $request = "/v1/positions";
   $data = array(
      "request" => $request
   );
   return $this->hash_request($data);
   }
   /*
   response
   [{
  "id":943715,
  "symbol":"btcusd",
  "status":"ACTIVE",
  "base":"246.94",
  "amount":"1.0",
  "timestamp":"1444141857.0",
  "swap":"0.0",
  "pl":"-2.22042"
   }]
   */

   public function close_position($position_id)
   {
   $request = "/v1/position/close";
   $data = array(
      "request" => $request,
      "position_id" => (int)$position_id
   );
   return $this->hash_request($data);
   }

   public function claim_position($position_id, $amount)
   {
   $request = "/v1/position/claim";
   $data = array(
      "request" => $request,
      "position_id" => (int)$position_id, 
      "amount" => $amount
   );
   return $this->hash_request($data);
   }
   /*
   response
   {
  "id":943715,
  "symbol":"btcusd",
  "status":"ACTIVE",
  "base":"246.94",
  "amount":"1.0",
  "timestamp":"1444141857.0",
  "swap":"0.0",
  "pl":"-2.2304"
   }
   */
   
   public function fetch_balance()
   {
   $request = "/v1/balances";
   $data = array(
      "request" => $request
   );
   return $this->hash_request($data);
   }
   /*
   response
   [{
  "type":"deposit",
  "currency":"btc",
  "amount":"0.0",
  "available":"0.0"
  },{
  "type":"deposit",
  "currency":"usd",
  "amount":"1.0",
  "available":"1.0"
  },{
  "type":"exchange",
  "currency":"btc",
  "amount":"1",
  "available":"1"
  },{
  "type":"exchange",
  "currency":"usd",
  "amount":"1",
  "available":"1"
  },{
  "type":"trading",
  "currency":"btc",
  "amount":"1",
  "available":"1"
  },{
  "type":"trading",
  "currency":"usd",
  "amount":"1",
  "available":"1"
   }]
   */
   
   public function margin_infos()
   {
   $request = "/v1/margin_infos";
   $data = array(
      "request" => $request
   );
   return $this->hash_request($data);
   }
   /*
   [{
  "margin_balance":"14.80039951",
  "tradable_balance":"-12.50620089",
  "unrealized_pl":"-0.18392",
  "unrealized_swap":"-0.00038653",
  "net_value":"14.61609298",
  "required_margin":"7.3569",
  "leverage":"2.5",
  "margin_requirement":"13.0",
  "margin_limits":[{
    "on_pair":"BTCUSD",
    "initial_margin":"30.0",
    "margin_requirement":"15.0",
    "tradable_balance":"-0.329243259666666667"
   }]
   */
   
   public function transfer($amount, $currency, $from, $to)
   {
   $request = "/v1/transfer";
   $data = array(
      "request" => $request,
      "amount" => $amount,
      "currency" => $currency,
      "walletfrom" => $from,
      "walletto" => $to
   );
   return $this->hash_request($data);
   }
   /*
   response
   [{
  "status":"success",
  "message":"1.0 USD transfered from Exchange to Deposit"
   }]
   */

   private function headers($data)
   {
      $data["nonce"] = strval(round(microtime(true) * 10000,0));
      $payload = base64_encode(json_encode($data));
      $signature = hash_hmac("sha384", $payload, $this->secret);
      return array(
         "X-BFX-APIKEY: " . $this->apikey,
         "X-BFX-PAYLOAD: " .$payload,
         "X-BFX-SIGNATURE: " . $signature
      );
   }

   private function hash_request($data)
   {
      $ch = curl_init();
      $bfurl = $this->url . $data["request"];
      $headers = $this->headers($data);
      curl_setopt_array($ch, array(
         CURLOPT_URL => $bfurl,
         CURLOPT_POST => true,
         CURLOPT_RETURNTRANSFER => true,
         CURLOPT_HTTPHEADER => $headers,
         CURLOPT_SSL_VERIFYPEER => false,
         CURLOPT_POSTFIELDS => ""
      ));
      $ccc = curl_exec($ch);
      return json_decode($ccc, true);
   }

}

?>

