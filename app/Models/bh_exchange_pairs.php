<?php

namespace Bowhead\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $exchange_id
 * @property string $exchange_pair
 */
class bh_exchange_pairs extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['exchange_id', 'exchange_pair'];

}
