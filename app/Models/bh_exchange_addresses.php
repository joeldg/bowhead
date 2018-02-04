<?php

namespace Bowhead\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $exchange_id
 * @property string $currency
 * @property string $address
 * @property string $updated_at
 * @property string $created_at
 * @property string $deleted_at
 */
class bh_exchange_addresses extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['exchange_id', 'currency', 'address', 'updated_at', 'created_at', 'deleted_at'];
}
