<?php
/**
 * Created by PhpStorm.
 * User: joeldg
 * Date: 4/8/17
 * Time: 9:36 PM
 */

namespace Bowhead\Strategy;
use Bowhead\Util;

/**
 * Class testStrategy
 * @package Bowhead\Strategy
 *
 *          This is a test class for a strategy with the bare-bones functionality.
 *          obviously add in further functions as needed.
 *
 *          USAGE:
 *              Accepts: an instrument such as BTC_USD, or multiple instruments as an array
 *                       if multiple instruments loop through them.
 *              Returns: true or false
 *
 *              use Bowhead\Util Ledger class for all buy and sell functions so ledger is properly updated.
 *              use Bowhead\Util Math class for all math functions not in trader extension.
 *
 */
class whaleclubStrategy
{
    /**
     * Instrument = BTC_USD, ETH_USD and so on.
     * @var
     */
    protected $instrument;

    /**
     * @var string
     */
    protected $description = "This is example strategy.";

    /**
     * @var array
     * override array for configs items
     */
    protected $configs = array('SELL_HOLD_TICKS'=>25);

    /**
     * testStrategy constructor.
     *
     * @param $instrument
     */
    function __construct($instrument)
    {
        $this->ledger = new Util\CoinBase;
        $this->instrument = $instrument;
    }

    /**
     *  all strategies need to have a think() function.
     */
    public function think()
    {
        /**
         *      - Load book
         *      - process book
         *      - do moving averages etc
         *      - update cache
         *      - do buys and sells
         */

        return true;
    }
}
