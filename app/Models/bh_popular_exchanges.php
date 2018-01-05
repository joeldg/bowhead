<?php

namespace Bowhead\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $exch_id
 * @property string $exchange
 * @property boolean $public_api
 * @property boolean $coinigy
 * @property boolean $ccxt
 * @property string $link
 * @property string $about
 * @property string $updated_at
 * @property string $created_at
 * @property string $deleted_at
 */
class bh_popular_exchanges extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['exch_id', 'exchange', 'public_api', 'coinigy', 'ccxt', 'link', 'about', 'updated_at', 'created_at', 'deleted_at'];

}
