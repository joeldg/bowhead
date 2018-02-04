<?php

namespace Bowhead\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $bh_exchanges_id
 * @property string $symbol
 * @property int $timestamp
 * @property string $datetime
 * @property float $high
 * @property float $low
 * @property float $bid
 * @property float $ask
 * @property float $vwap
 * @property float $open
 * @property float $close
 * @property float $first
 * @property float $last
 * @property float $change
 * @property float $percentage
 * @property float $average
 * @property float $baseVolume
 * @property float $quoteVolume
 * @property string $updated_at
 * @property string $created_at
 * @property string $deleted_at
 */
class bh_tickers extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['bh_exchanges_id', 'symbol', 'timestamp', 'datetime', 'high', 'low', 'bid', 'ask', 'vwap', 'open', 'close', 'first', 'last', 'change', 'percentage', 'average', 'baseVolume', 'quoteVolume', 'updated_at', 'created_at', 'deleted_at'];
}
