<?php
/**
 * Created by PhpStorm.
 * User: joeldg
 * Date: 6/25/17
 * Time: 1:46 PM
 */

namespace Bowhead\Traits;

use Bowhead\Util\BrokersUtil;
use Bowhead\Util\Console;
use Bowhead\Util\Indicators;

/**
 * Class Signals
 * @package Bowhead\Traits
 *          Forex signals
 *
 *          RSI (14)
 *          Stoch (9,6)
 *          STOCHRS(14)
 *          MACD(12,26)
 *          ADX(14)
 *          Williams %R
 *          CCI(14)
 *          ATR(14)
 *          Highs/Lows(14)
 *          Ultimate Oscillator
 *          ROC
 *          Bull/Bear Power(13) Elder-Ray
 */
trait Signals
{
    /**
     * @var
     */
    protected $indicators;

    /**
     * @param bool $return
     * @param bool $compile
     */
    public function signals($return=false, $compile=false, $instruments=null , $limit = 168)
    {
        $lines = [];
        $inds        = ['rsi','stoch','stochrsi','macd','adx','willr','cci','atr','hli','ultosc','roc','er'];
        if (empty($instruments)) {
            $instruments = ['BTC/USD', 'USD_JPY', 'NZD_USD', 'EUR_GBP', 'USD_CAD', 'USD_CNH', 'USD_MXN', 'USD_TRY', 'AUD_USD', 'EUR_USD', 'USD_CHF'];
        }
        $indicators  = new Indicators();
        $console     = new Console();
        $util        = new BrokersUtil();

        foreach ($instruments as $exchange_id => $pair) {

            $data  = $this->getRecentData($pair);

            //take last if $exchange_id is not defined needed now because we can get data from multiple exchanges
	        if(!isset($data[$exchange_id])){
	        	array_pop($data);
	        }
	        else{
		        $data = $data[$exchange_id];
	        }

            $flags = [];
            $flags['rsi']         = $indicators->rsi($pair, $data);
            $flags['stoch']       = $indicators->stoch($pair, $data);
            $flags['stochrsi']    = $indicators->stochrsi($pair, $data);
            $flags['macd']        = $indicators->macd($pair, $data);
            $flags['adx']         = $indicators->adx($pair, $data);
            $flags['willr']       = $indicators->willr($pair, $data);
            $flags['cci']         = $indicators->cci($pair, $data);
            $flags['atr']         = $indicators->atr($pair, $data);
            $flags['hli']         = $indicators->hli($pair, $data);
            $flags['ultosc']      = $indicators->ultosc($pair, $data);
            $flags['roc']         = $indicators->roc($pair, $data);
            $flags['er']          = $indicators->er($pair, $data);

            $symbollines[$pair] = $flags;
        }

        if ($compile) {
            $return = $ret = [];
            foreach($symbollines as $symbol => $datas) {
                $ret[$symbol] = [];
                $ret[$symbol]['buy']  = 0;
                $ret[$symbol]['sell'] = 0;

                foreach($datas as $data) {
                    $ret[$symbol]['buy']  += ($data == 1 ? 1 : 0);
                    $ret[$symbol]['sell'] += ($data == -1 ? 1 : 0);
                }
            }
            foreach ($ret as $k => $r) {
                $return[$k] = 'NONE';
                $return[$k] = ($r['buy'] > 6 ? 'WEAK BUY' : $return[$k]);
                $return[$k] = ($r['buy'] > 8 ? 'GOOD BUY' : $return[$k]);
                $return[$k] = ($r['buy'] > 9 ? 'STRONG BUY' : $return[$k]);
                $return[$k] = ($r['buy'] > 10 ? 'VERY STRONG BUY' : $return[$k]);
                $return[$k] = ($r['sell'] > 6 ? 'WEAK SELL' : $return[$k]);
                $return[$k] = ($r['sell'] > 8 ? 'GOOD SELL' : $return[$k]);
                $return[$k] = ($r['sell'] > 9 ? 'STRONG SELL' : $return[$k]);
                $return[$k] = ($r['sell'] > 10 ? 'VERY STRONG SELL' : $return[$k]);
            }
            return $return;
        }

        // if return is set we just return the raw data.
        if ($return) {
            return $symbollines;
        }

        $lines = [];
        $lines['top'] = '';
        $output = '';
        foreach($instruments as $instrument) {
            $lines['top'] .= str_pad($instrument, 10);
            foreach($inds as $ind) {
                if(!isset($lines[$ind])){
                    $lines[$ind] = '';
                }
                $color = ($symbollines[$instrument][$ind] > 0 ? 'bg_green' : ($symbollines[$instrument][$ind] < 0 ? 'bg_red' : 'bg_black'));
                $lines[$ind] .= $console->colorize(str_pad($ind, 10), $color);
            }
        }
        echo "\n".@$lines['top'];
        foreach($inds as $ind) {
            echo "\n".$lines[$ind];
        }
        echo "\n\n";
        return null;
    }
}