<?php

namespace Bowhead\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $auth_id
 * @property string $exch_name
 * @property int $exch_id
 * @property string $auth_key
 * @property string $auth_secret
 * @property string $auth_optional1
 * @property string $auth_nickname
 * @property string $auth_updated
 * @property bool $auth_active
 * @property bool $auth_trade
 * @property bool $exch_trade_enabled
 * @property string $updated_at
 * @property string $created_at
 * @property string $deleted_at
 */
class bh_exchange_accounts extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['auth_id', 'exch_name', 'exch_id', 'auth_key', 'auth_secret', 'auth_optional1', 'auth_nickname', 'auth_updated', 'auth_active', 'auth_trade', 'exch_trade_enabled', 'updated_at', 'created_at', 'deleted_at'];
}
