<?php
/**
 * Created by PhpStorm.
 * User: joeldg.
 */

namespace Bowhead\Util;

/**
 * Class Other.
 */
class Other
{
    /**
     * @param $orders
     *
     * @return float|int
     *                   Volume weighted average price..
     *                   not fully implemented yet
     */
    public function vwap($orders)
    {
        $count = count($orders);
        $shares = $total = 0;
        foreach ($orders as $order) {
            $shares += $order['size'];
            $total += $order['size'] * $order['price'];
        }

        return $shares == 0 ? 0 : round($total / $shares, 2);
    }

    /**
     * @param $input_data
     * @param $period
     * @param $x_end
     *
     * @return array
     *
     *          This is not fully implemented yet.
     */
    public function ahrens_moving_average($input_data,	// data to be smoothed
                                   $period,		// smoothing window
                                   $x_end)
    {	// end of input data

        //--------------------------------------------------------------
        // create the output array

        $avg = [];

        //--------------------------------------------------------------
        // the AMA may be used to smooth raw data or the output of
        // other calculations. since other calculations may introduce
        // significant phase lag so there is no guarantee that the
        // input data will actually start at the beginning of the
        // array passed to this function. this loop searches for the
        // first actual datapoint in the input series.

        $x_start = 1;
        for ($a = $x_start; $a <= $x_end; $a++) {
            if (isset($input_data[$a]) && is_numeric($input_data[$a])) {
                $x_start = $a;
                break;
            }
        }

        //--------------------------------------------------------------
        // the first raw data point in a series may be (significantly)
        // divergent from the data that follows. this loop creates a
        // reasonably representative set of initial values to seed the
        // average.  it uses an "expanding period" simple moving average
        // over the first N samples (where N equals the period of the
        // average)

        $count = 0;
        $total = 0;
        for ($a = $x_start; $a < $x_start + $period && $a <= $x_end; $a++) {
            $count++;
            $total += $input_data[$a];
            $avg[$a] = $total / $count;
        }

        //--------------------------------------------------------------
        // once the seed values have been calculated, shift gears and
        // calculate the AMA for $x_start + $period through $x_end

        for ($a = $x_start + $period; $a <= $x_end; $a++) {
            $numerator = $input_data[$a] - ($avg[$a - 1] + $avg[$a - $period]) / 2;
            $avg[$a] = $avg[$a - 1] + $numerator / $period;
        }

        return $avg;
    }
}
