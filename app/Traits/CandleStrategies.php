<?php
/**
 * Created by PhpStorm.
 * User: joeldg
 * Date: 7/6/17
 * Time: 10:11 PM.
 */

namespace Bowhead\Traits;

use Bowhead\Util\Indicators;

/**
 * Class CandleStrategies.
 */
trait CandleStrategies
{
    public function bowhead_ema_candle($pair, $data, $return_full = false)
    {
        $ema = trader_ema($data, 20);
        $ema = @array_pop($ema) ?? 0;
        $cand = $this->candle_value();

        $current_price = array_pop($data['close']);
        $previous_price = array_pop($data['close']);

        if ($cand['current']['indecision'] > 0) {
            return 0;
        }
        if ($cand['current']['reverse_bear'] > 60 && $current_price > $ema && $previous_price < $ema) {
            return 1;
        }
        if ($cand['current']['reverse_bull'] > 60 && $current_price < $ema && $previous_price > $ema) {
            return -1;
        }

        return 0;
    }

    public function bowhead_rsi_candle($pair, $data, $return_full = false)
    {
        $ind = new Indicators();
        $rsi = $ind->rsi($pair, $data['close'], 14);
        $rsi = @array_pop($rsi) ?? 0;
        $cand = $this->candle_value();

        $current_price = array_pop($data['close']);
        $previous_price = array_pop($data['close']);

        if ($cand['current']['indecision'] > 0) {
            return 0;
        }
        if ($cand['current']['reverse_bear'] > 60 && $rsi > 0) {
            return 1;
        }
        if ($cand['current']['reverse_bull'] > 60 && $rsi < 0) {
            return -1;
        }

        return 0;
    }
}
