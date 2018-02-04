<?php
/**
 * Created by PhpStorm.
 * User: joeldg
 * Date: 4/8/17
 * Time: 9:36 PM.
 */

namespace Bowhead\Strategy;

use Bowhead\Util;

/**
 * Class testStrategy.
 */
class testStrategy
{
    /**
     * Instrument = BTC_USD, ETH_USD and so on.
     *
     * @var
     */
    protected $instrument;

    /**
     * @var string
     */
    protected $description = 'This is example strategy.';

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
    public function __construct($instrument)
    {
        $this->ledger = new Util\CoinBase();
        $this->instrument = $instrument;
    }

    /**
     *  all strategies need to have a think() function.
     */
    public function think()
    {
        /*
         *      - Load book
         *      - process book
         *      - do moving averages etc
         *      - update cache
         *      - do buys and sells
         */

        return true;
    }
}
