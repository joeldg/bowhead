<?php

namespace Bowhead\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $auth_id
 * @property string $exch_name
 * @property int $exch_id
 * @property boolean $exch_trade_enabled
 * @property string $balance_curr_code
 * @property float $balance_amount_avail
 * @property float $balance_amount_held
 * @property float $balance_amount_total
 * @property float $btc_balance
 * @property float $last_price
 * @property string $updated_at
 * @property string $created_at
 * @property string $deleted_at
 */
class bh_exchange_balances extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['auth_id', 'exch_name', 'exch_id', 'balance_curr_code', 'balance_amount_avail', 'balance_amount_held', 'balance_amount_total', 'btc_balance', 'last_price', 'updated_at', 'created_at', 'deleted_at'];

}
