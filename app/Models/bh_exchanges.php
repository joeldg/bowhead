<?php

namespace Bowhead\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $exchange
 * @property bool $coinigy
 * @property int $coinigy_id
 * @property string $coinigy_exch_code
 * @property float $coinigy_exch_fee
 * @property bool $coinigy_trade_enabled
 * @property bool $coinigy_balance_enabled
 * @property bool $hasFetchTickers
 * @property bool $hasFetchOHLCV
 * @property bool $use
 * @property string $data
 * @property string $updated_at
 * @property string $created_at
 * @property string $deleted_at
 */
class bh_exchanges extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['exchange', 'ccxt', 'coinigy', 'coinigy_id', 'coinigy_exch_code', 'coinigy_exch_fee', 'coinigy_trade_enabled', 'coinigy_balance_enabled', 'hasFetchTickers', 'hasFetchOHLCV', 'use', 'data', 'url', 'url_api', 'url_doc', 'updated_at', 'created_at', 'deleted_at'];
}
