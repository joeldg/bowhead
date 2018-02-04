<?php

namespace Bowhead\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $bh_exchanges_id
 * @property string $symbol
 * @property int $timestamp
 * @property string $datetime
 * @property float $open
 * @property float $high
 * @property float $low
 * @property float $close
 * @property float $volume
 * @property string $updated_at
 * @property string $created_at
 * @property string $deleted_at
 */
class bh_ohlcvs extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['bh_exchanges_id', 'symbol', 'timestamp', 'datetime', 'open', 'high', 'low', 'close', 'volume', 'updated_at', 'created_at', 'deleted_at'];
}
