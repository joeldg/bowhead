<?php

namespace Bowhead\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $exchange
 * @property boolean $hasFetchTickers
 * @property boolean $hasFetchOHLCV
 * @property boolean $use
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
    protected $fillable = ['exchange', 'hasFetchTickers', 'hasFetchOHLCV', 'use', 'data', 'updated_at', 'created_at', 'deleted_at'];

}
