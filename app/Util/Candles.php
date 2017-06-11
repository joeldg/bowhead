<?php
/**
 * Created by PhpStorm.
 * User: joeldg
 * Date: 4/14/17
 * Time: 12:57 PM
 */
namespace Bowhead\Util;

/**
 * Class Candles
 * @package Bowhead\Util
 *
 *          Stock candles are traditional Japanese price graphs and all the names for candles
 *          are from Japanese military maneuvers and traditional stories, or are words in Japanese such as
 *          Harami meaning 'pregnant'
 *
 *          Candles are NOT specifically buy/sell signals, look them up before you use them.
 *          http://www.investinganswers.com/financial-dictionary
 *          http://www.investopedia.com/dictionary/
 *
 *          use allCandles() below to get a complete candle set on your data window.
 *
 *          Not all possible types of candles are here, many two (tweezers) and single (white soldier etc) candles are
 *          missing from this list, there are TONS of different candles abut this list has what is generally accepted as
 *          the main ones, and this is 100% of the TA-Lib port to PHP.
 *
 *          Examples:
 *
 *          bears: Bearish Engulfing, Dark Cloud cover, Bearish counter attack, Bearish Harami, eveningstar reversal
 *          http://www.candlesticker.com/BearishPatterns.aspx?lang=en
 *
 *          bulls: Bullish Engulfing, Bullish Piercing Pattern, Bullish counter attack, Bullish Harami, Morning Star reversal
 *          http://www.candlesticker.com/BullishPatterns.aspx?lang=en
 */
class Candles
{
    /**
     * @var array
     *
     *      Here is all the candles
     */
    public $candles = array (
        'trader_cdl2crows'              => 'Two Crows',
        'trader_cdl3blackcrows'         => 'Three Black Crows',
        'trader_cdl3inside'             => 'Three Inside Up/Down',
        'trader_cdl3linestrike'         => 'Three-Line Strike',
        'trader_cdl3outside'            => 'Three Outside Up/Down',
        'trader_cdl3starsinsouth'       => 'Three Stars In The South',
        'trader_cdl3whitesoldiers'      => 'Three Advancing White Soldiers',
        'trader_cdlabandonedbaby'       => 'Abandoned Baby',
        'trader_cdladvanceblock'        => 'Advance Block',
        'trader_cdlbelthold'            => 'Belt-hold',
        'trader_cdlbreakaway'           => 'Breakaway',
        'trader_cdlclosingmarubozu'     => 'Closing Marubozu',
        'trader_cdlconcealbabyswall'    => 'Concealing Baby Swallow',
        'trader_cdlcounterattack'       => 'Counterattack',
        'trader_cdldarkcloudcover'      => 'Dark Cloud Cover',
        'trader_cdldoji'                => 'Doji',
        'trader_cdldojistar'            => 'Doji Star',
        'trader_cdldragonflydoji'       => 'Dragonfly Doji',
        'trader_cdlengulfing'           => 'Engulfing Pattern',
        'trader_cdleveningdojistar'     => 'Evening Doji Star',
        'trader_cdleveningstar'         => 'Evening Star',
        'trader_cdlgapsidesidewhite'    => 'Up/Down-gap side-by-side white lines',
        'trader_cdlgravestonedoji'      => 'Gravestone Doji',
        'trader_cdlhammer'              => 'Hammer',
        'trader_cdlhangingman'          => 'Hanging Man',
        'trader_cdlharami'              => 'Harami Pattern',
        'trader_cdlharamicross'         => 'Harami Cross Pattern',
        'trader_cdlhighwave'            => 'High-Wave Candle',
        'trader_cdlhikkake'             => 'Hikkake Pattern',
        'trader_cdlhikkakemod'          => 'Modified Hikkake Pattern',
        'trader_cdlhomingpigeon'        => 'Homing Pigeon',
        'trader_cdlidentical3crows'     => 'Identical Three Crows',
        'trader_cdlinneck'              => 'In-Neck Pattern',
        'trader_cdlinvertedhammer'      => 'Inverted Hammer',
        'trader_cdlkicking'             => 'Kicking',
        'trader_cdlkickingbylength'     => 'Kicking - bull/bear determined by the longer marubozu',
        'trader_cdlladderbottom'        => 'Ladder Bottom',
        'trader_cdllongleggeddoji'      => 'Long Legged Doji',
        'trader_cdllongline'            => 'Long Line Candle',
        'trader_cdlmarubozu'            => 'Marubozu',
        'trader_cdlmatchinglow'         => 'Matching Low',
        'trader_cdlmathold'             => 'Mat Hold',
        'trader_cdlmorningdojistar'     => 'Morning Doji Star',
        'trader_cdlmorningstar'         => 'Morning Star',
        'trader_cdlonneck'              => 'On-Neck Pattern',
        'trader_cdlpiercing'            => 'Piercing Pattern',
        'trader_cdlrickshawman'         => 'Rickshaw Man',
        'trader_cdlrisefall3methods'    => 'Rising/Falling Three Methods',
        'trader_cdlseparatinglines'     => 'Separating Lines',
        'trader_cdlshootingstar'        => 'Shooting Star',
        'trader_cdlshortline'           => 'Short Line Candle',
        'trader_cdlspinningtop'         => 'Spinning Top',
        'trader_cdlstalledpattern'      => 'Stalled Pattern',
        'trader_cdlsticksandwich'       => 'Stick Sandwich',
        'trader_cdltakuri'              => 'Takuri (Dragonfly Doji with very long lower shadow)',
        'trader_cdltasukigap'           => 'Tasuki Gap',
        'trader_cdlthrusting'           => 'Thrusting Pattern',
        'trader_cdltristar'             => 'Tristar Pattern',
        'trader_cdlunique3river'        => 'Unique 3 River',
        'trader_cdlupsidegap2crows'     => 'Upside Gap Two Crows',
        'trader_cdlxsidegap3methods'    => 'Upside/Downside Gap Three Methods'
    );

    /**
     * @param string $pair
     * @param null   $data
     *
     * @return array
     *
     *          Run our dataset against ALL the trader candles types
     *          return an array matching the datapoints:
     *
     *          if array entry is non-zero, > 0 bullish, < 0 bearish
     *
     *          - notfound  = candle not found anywhere in entire dataset
     *          - range     = candle found in the entire dataset
     *          - recently  = candle found in the most recent three periods (days/hours)
     *          - current   = candle found in the single most recent
     *          - datafor   = close data surrounding the candle on either side
     */
    public function allCandles($pair='BTC/USD', $data=null)
    {
        $util = new BrokersUtil();
        $ret = array();
        if (empty($data)) {
            $data = $util->getRecentData($pair);
        }
        foreach($this->candles as $cdlfunc => $name) {
            if (function_exists($cdlfunc)) {
                $tempdata = $cdlfunc($data['open'], $data['high'], $data['low'], $data['close']);
                if (empty($tempdata)) {
                    continue;
                }

                $cdlfunc = str_replace('trader_cdl','', $cdlfunc);

                $tmp = array_map('abs', $tempdata); // remove negatives
                $sum = array_sum($tmp);             // sum it all
                if ($sum == 0) {
                    $ret['notfound'][$cdlfunc] = $name;
                }
                foreach ($tempdata as $key => $temp) {
                    $ret['all'][$cdlfunc] = $temp;
                    if (abs($temp) > 0) {
                        $ret['range'][$cdlfunc]    = $name; // that we found this candle
                        $ret['location'][$cdlfunc][] = $key;  // the location in the dataset where this candle is
                    }
                }

                $tempdataReIndexed = array_values($tempdata);
                $closeData = array_values($data['close']);
                foreach ($tempdataReIndexed as $idx => $cand) {
                    $sindex = (($idx)-3 < 0 ? 3 : $idx);
                    if ($sindex+4 > count($closeData)){
                        $sindex = $sindex - 4;
                    }
                    $currents = array_slice($closeData, $sindex-3, 7);
                    if ($cand <> 0) {
                        $lastfive = @implode(",", $currents);
                        $ret['datafor'][$cdlfunc] = $lastfive;
                    }
                }

                $lastBit = array_slice($tempdata, -3, 3);
                foreach ($lastBit as $test) {
                    if ($test <> 0) {
                        $ret['recently'][$cdlfunc] = $test;
                    }
                }
                $last = array_pop($tempdata);
                if ($last <> 0) {
                    $ret['current'][$cdlfunc] = $last;
                }
            } else {
                $ret['undefined'][] = $cdlfunc;
            }
        }
        #$ret['close'] = $data['close']; #array_pop($data['close']);
        #$ret['data'] = $data; // maybe useful for graphs?

        return $ret;
    }

}