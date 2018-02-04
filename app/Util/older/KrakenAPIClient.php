<?php

namespace Bowhead\Util;

/**
 * Reference implementation for Kraken's REST API.
 *
 * See https://www.kraken.com/help/api for more info.
 *
 *
 * The MIT License (MIT)
 *
 * Copyright (c) 2013 Payward, Inc
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
class KrakenAPIException extends \ErrorException
{
}

class KrakenAPI
{
    protected $key;     // API key
    protected $secret;  // API secret
    protected $url;     // API base URL
    protected $version; // API version
    protected $curl;    // curl handle

    /**
     * Constructor for KrakenAPI.
     *
     * @param string $key       API key
     * @param string $secret    API secret
     * @param string $url       base URL for Kraken API
     * @param string $version   API version
     * @param bool   $sslverify enable/disable SSL peer verification.  disable if using beta.api.kraken.com
     */
    public function __construct($key, $secret, $url = 'https://api.kraken.com', $version = '0', $sslverify = true)
    {
        $this->key = $key;
        $this->secret = $secret;
        $this->url = $url;
        $this->version = $version;
        $this->curl = curl_init();

        curl_setopt_array($this->curl, [
                CURLOPT_SSL_VERIFYPEER => $sslverify,
                CURLOPT_SSL_VERIFYHOST => 2,
                CURLOPT_USERAGENT      => 'Kraken PHP API Agent',
                CURLOPT_POST           => true,
                CURLOPT_RETURNTRANSFER => true, ]
        );
    }

    public function __destruct()
    {
        curl_close($this->curl);
    }

    /**
     * Query public methods.
     *
     * @param string $method  method name
     * @param array  $request request parameters
     *
     * @throws KrakenAPIException
     *
     * @return object request result on success
     */
    public function QueryPublic($method, array $request = [])
    {
        // build the POST data string
        $postdata = http_build_query($request, '', '&');

        // make request
        curl_setopt($this->curl, CURLOPT_URL, $this->url.'/'.$this->version.'/public/'.$method);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, []);
        $result = curl_exec($this->curl);
        if ($result === false) {
            throw new KrakenAPIException('CURL error: '.curl_error($this->curl));
        }
        // decode results
        $result = json_decode($result, false);
        if (!is_object($result)) {
            throw new KrakenAPIException('JSON decode error');
        }
        return $result;
    }

    /**
     * Query private methods.
     *
     * @param string $method  method path
     * @param array  $request request parameters
     *
     * @throws KrakenAPIException
     *
     * @return object request result on success
     */
    public function QueryPrivate($method, array $request = [])
    {
        if (!isset($request['nonce'])) {
            // generate a 64 bit nonce using a timestamp at microsecond resolution
            // string functions are used to avoid problems on 32 bit systems
            $nonce = explode(' ', microtime());
            $request['nonce'] = $nonce[1].str_pad(substr($nonce[0], 2, 6), 6, '0');
        }

        // build the POST data string
        $postdata = http_build_query($request, '', '&');

        // set API key and sign the message
        $path = '/'.$this->version.'/private/'.$method;
        $sign = hash_hmac('sha512', $path.hash('sha256', $request['nonce'].$postdata, true), base64_decode($this->secret), true);
        $headers = [
            'API-Key: '.$this->key,
            'API-Sign: '.base64_encode($sign),
        ];

        // make request
        curl_setopt($this->curl, CURLOPT_URL, $this->url.$path);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($this->curl);
        if ($result === false) {
            throw new KrakenAPIException('CURL error: '.curl_error($this->curl));
        }
        // decode results
        $result = json_decode($result);
        if (!is_object($result)) {
            throw new KrakenAPIException('JSON decode error');
        }
        return $result;
    }
}
