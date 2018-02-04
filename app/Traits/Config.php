<?php
/**
 * Created by PhpStorm.
 * User: joeldg
 * Date: 12/22/17
 * Time: 5:45 PM.
 */

namespace Bowhead\Traits;

use Bowhead\Models;

/**
 * Class Config.
 */
trait Config
{
    /**
     * @param $val
     *
     * @return bool|\Illuminate\Database\Eloquent\Model|mixed|null|string|static
     */
    public static function bowhead_config($val)
    {
        try {
            $ret = Models\bh_configs::firstorcreate(['item' => $val]); //Models\bh_configs::where('item', '=', $val)->first();
            if (empty($ret->value)) {
                $ret = env($val);
                if (!empty($ret)) {
                    return $ret;
                } else {
                    return false;
                }
            } else {
                return $ret->value;
            }
        } catch (\Exception $e) {
            return false;
        }
    }
}
