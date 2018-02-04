<?php
/**
 * Created by PhpStorm.
 * User: joeldg
 * Date: 7/4/17
 * Time: 10:46 AM.
 */

namespace Bowhead\Traits;

/**
 * Class Pivots.
 */
trait Pivots
{
    public function calcFibonacci($data, $period = 15)
    {
        if (empty($data)) {
            $data = $this->getRecentData('BTC/USD');
        }
        /*
        Pivot Point   (P) = (High + Low + Close)/3
        Support 1    (S1) = P - {.382 * (High  -  Low)}
        Support 2    (S2) = P - {.618 * (High  -  Low)}
        Support 3    (S3) = P - {1 * (High  -  Low)}
        Resistance 1 (R1) = P + {.382 * (High  -  Low)}
        Resistance 2 (R2) = P + {.618 * (High  -  Low)}
        Resistance 3 (R3) = P + {1 * (High  -  Low)}
        //*/
        $data['high'] = array_values($data['high']);
        $data['low'] = array_values($data['low']);
        $data['close'] = array_values($data['close']);
        $num = count($data['high']) - (round($period / 2) * 2);
        $ret = [];
        for ($a = $num; $a < count($data['high']); $a++) {
            $p = ($data['high'][$a] + $data['low'][$a] + $data['close'][$a]) / 3;
            $s1 = $p - (.382 * ($data['high'][$a] - $data['low'][$a]));
            $s2 = $p - (.618 * ($data['high'][$a] - $data['low'][$a]));
            $s3 = $p - (1 * ($data['high'][$a] - $data['low'][$a]));
            $r1 = $p + (.382 * ($data['high'][$a] - $data['low'][$a]));
            $r2 = $p + (.618 * ($data['high'][$a] - $data['low'][$a]));
            $r3 = $p + (1 * ($data['high'][$a] - $data['low'][$a]));

            /* get the average for the prior period */
            $ret['P'] = ((@$ret['P'] + $p) / 2) ?? $p;
            $ret['S1'] = ((@$ret['S1'] + $s1) / 2) ?? $s1;
            $ret['S2'] = ((@$ret['S2'] + $s2) / 2) ?? $s2;
            $ret['S3'] = ((@$ret['S3'] + $s3) / 2) ?? $s3;
            $ret['R1'] = ((@$ret['R1'] + $r1) / 2) ?? $r1;
            $ret['R2'] = ((@$ret['R2'] + $r2) / 2) ?? $r2;
            $ret['R3'] = ((@$ret['R3'] + $r3) / 2) ?? $r3;
        }

        return $ret;
    }

    public function calcDemark($data, $period = 120)
    {
        if (empty($data)) {
            $data = $this->getRecentData('BTC/USD');
        }
        /*
        If Close < Open, then X = High + (2 x Low) + Close
        If Close > Open, then X = (2 x High) + Low + Close
        If Close = Open, then X = High + Low + (2 x Close)
        Pivot Point (P) = X/4
        Support 1 (S1) = X/2 - High
        Resistance 1 (R1) = X/2 - Low
        //*/
        $data['open'] = array_values($data['open']);
        $data['high'] = array_values($data['high']);
        $data['low'] = array_values($data['low']);
        $data['close'] = array_values($data['close']);
        $num = count($data['high']) - (round($period / 2) * 2);
        $ret = [];
        for ($a = $num; $a < count($data['high']); $a++) {
            if ($data['close'][$a] < $data['open'][$a]) {
                $x = ($data['high'][$a] + ($data['low'][$a] * 2) + $data['close'][$a]);
            }
            if ($data['close'][$a] > $data['open'][$a]) {
                $x = (($data['high'][$a] * 2) + $data['low'][$a] + $data['close'][$a]);
            }
            if ($data['close'][$a] > $data['open'][$a]) {
                $x = ($data['high'][$a] + $data['low'][$a] + ($data['close'][$a] * 2));
            }
            $p = $x / 4;
            $s1 = $x / 2 - $data['high'][$a];
            $r1 = $x / 2 - $data['low'][$a];

            $ret['P'] = ((@$ret['P'] + $p) / 2) ?? $p;
            $ret['S1'] = ((@$ret['S1'] + $s1) / 2) ?? $s1;
            $ret['R1'] = ((@$ret['R1'] + $r1) / 2) ?? $r1;
        }

        return $ret;
    }

    public function calcPivot($data, $period = 120)
    {
        if (empty($data)) {
            $data = $this->getRecentData('BTC/USD');
        }
        /*
        Pivot Point (P) = (High + Low + Close)/3
        Support 1 (S1) = (P x 2) - High
        Support 2 (S2) = P  -  (High  -  Low)
        Resistance 1 (R1) = (P x 2) - Low
        Resistance 2 (R2) = P + (High  -  Low)
        //*/
        $data['high'] = array_values($data['high']);
        $data['low'] = array_values($data['low']);
        $data['close'] = array_values($data['close']);
        $num = count($data['high']) - (round($period / 2) * 2);
        $ret = [];
        for ($a = $num; $a < count($data['high']); $a++) {
            $p = ($data['high'][$a] + $data['low'][$a] + $data['close'][$a]) / 3;
            $s1 = ($p * 2) - $data['high'][$a];
            $s2 = ($p - ($data['high'][$a] - $data['low'][$a]));
            $r1 = ($p * 2) - $data['low'][$a];
            $r2 = ($p + ($data['high'][$a] - $data['low'][$a]));

            $ret['P'] = ((@$ret['P'] + $p) / 2) ?? $p;
            $ret['S1'] = ((@$ret['S1'] + $s1) / 2) ?? $s1;
            $ret['S2'] = ((@$ret['S2'] + $s2) / 2) ?? $s2;
            $ret['R1'] = ((@$ret['R1'] + $r1) / 2) ?? $r1;
            $ret['R2'] = ((@$ret['R2'] + $r2) / 2) ?? $r2;
        }

        return $ret;
    }
}
