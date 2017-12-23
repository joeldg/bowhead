<?php
/**
 * Created by PhpStorm.
 * User: joeldg
 * Date: 12/22/17
 * Time: 5:45 PM
 */

namespace Bowhead\Traits;

use Bowhead\Models;

trait Config
{
    public function bowhead_config($val) {
        try {
            $ret = Models\bh_configs::where('item', '=', $val)->first();
            return $ret->value;
        } catch (\Exception $e) {
            return false;
        }

    }
}