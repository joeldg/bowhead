<?php
/**
 * Created by PhpStorm.
 */

namespace Bowhead\Util;

class Console
{
    /**
     * @return null
     *              buzz the console to get the users attention.
     */
    public function buzzer()
    {
        echo "\x07";
        echo "\x07";
        echo "\x07";
    }

    /**
     * @param     $str
     * @param int $l
     *
     * @return array
     */
    public function str_split_unicode($str, $l = 0)
    {
        if ($l > 0) {
            $ret = [];
            $len = mb_strlen($str, 'UTF-8');
            for ($i = 0; $i < $len; $i += $l) {
                $ret[] = mb_substr($str, $i, $l, 'UTF-8');
            }

            return $ret;
        }

        return preg_split('//u', $str, -1, PREG_SPLIT_NO_EMPTY);
    }

    public function mb_str_pad($input, $pad_length, $pad_string = ' ', $pad_type = STR_PAD_RIGHT)
    {
        $diff = strlen($input) - mb_strlen($input);

        return str_pad($input, $pad_length + $diff, $pad_string, $pad_type);
    }

    /**
     * @param        $dataSet
     * @param string $headers
     *
     * @return string
     *                INSIDE ╤ ╧ ╟ ╢ │ ─
     *                OUTSIDE ╔ ═ ╗║ ║ ╚ ═ ╝ ╠ ╣ ╬
     */
    public function tableFormatArray($dataSet, $headers = null, $use_theme = 'unicode', $set_width = 0, $boldheaders = 0)
    {
        // ☠
        $dataSet = array_filter($dataSet, 'strlen'); // filter out blanks
        //                   '012345678901234'
        $_theme['unicode'] = '─═╔╗╚╝╤╧╟╢╠╣│║╪'; // unicode
        $_theme['x'] = '--xxxxxxxxxx||x'; // x
        $_theme['dots'] = '.......:::::::.'; // dots
        $_theme['boxey'] = '███████████████'; // boxey style
        $_theme['mysql'] = '--++++++++++||+'; // mysql style
        $_theme['minimal'] = '--             '; // minimal
        $_theme['format'] = '               '; // format
        $_theme['sun'] = '  ☀☀☀☀☀☀☀☀☀☀   '; // sun
        $_theme['wrap'] = '--++++--|||| | '; // outside wrap
        $theme = $this->str_split_unicode($_theme[$use_theme], 0);

        $min_themes = ['minimal', 'format'];

        $val = $hval = $hkey = $key_width = $val_width = $height = 0;
        $tobold = [];
        if ($set_width) {
            $key_width = $val_width = round($set_width / 2);
        }

        foreach ($dataSet as $key => $val) {
            if (strpos($key, "\n") || strpos($val, "\n")) {
                $rows1 = array_filter(explode("\n", $key));
                $rows2 = array_filter(explode("\n", $val));
                $key_width = ((mb_strlen(trim($rows1[0], "\r\n")) > $key_width) ? mb_strlen(trim($rows1[0], "\r\n")) : $key_width);
                $val_width = ((mb_strlen(trim($rows2[0], "\r\n")) > $val_width) ? mb_strlen(trim($rows2[0], "\r\n")) : $val_width);
                $height = ((count($rows1) > $height) ? count($rows1) : $height);
                $height = ((count($rows2) > $height) ? count($rows2) : $height);
            } else {
                $key_width = (mb_strlen($key) > $key_width ? mb_strlen($key) : $key_width);
                $val_width = (mb_strlen($val) > $val_width ? mb_strlen($val) : $val_width);
            }
            if (!empty($headers)) {
                foreach ($headers as $hkey => $hval) {
                    $tobold[] = $hkey;
                    $tobold[] = $hval;
                    $key_width = (mb_strlen($hkey) > $key_width ? mb_strlen($hkey) : $key_width);
                    $val_width = (mb_strlen($hval) > $val_width ? mb_strlen($hval) : $val_width);
                }
            }
        }
        if (!in_array($use_theme, $min_themes)) {
            $key_width = $key_width + 2;
            $val_width = $val_width + 2;
        }

        $total_width = ($key_width + 2) + ($val_width + 2) + 3;
        $output = $theme[2].str_repeat($theme[1], $total_width - 2).$theme[3]."\n";

        if (!empty($headers)) {
            if (!in_array($use_theme, $min_themes)) {
                $output = $theme[2].str_repeat($theme[1], $key_width + 2).$theme[6].str_repeat($theme[1], $val_width + 2).$theme[3]."\n";
            } else {
                $output = '';
            }
            $output .= $theme[13].$this->mb_str_pad(' '.$hkey.' ', $key_width + 2, ' ').$theme[12].str_pad(' '.$hval.' ', $val_width + 2, ' ', (is_numeric($hval) ? STR_PAD_LEFT : STR_PAD_RIGHT)).$theme[13]."\n";
            $output .= $theme[10].str_repeat($theme[1], $key_width + 2).$theme[14].str_repeat($theme[1], $val_width + 2).$theme[11]."\n";
        }
        foreach ($dataSet as $key => $val) {
            if (strpos($key, '**')) {
                $key = str_replace('**', '', $key);
                $tobold[] = $key;
                $tobold[] = $val;
                if (!in_array($use_theme, $min_themes)) {
                    $output .= $theme[10].str_repeat($theme[1], $key_width + 2).$theme[14].str_repeat($theme[1], $val_width + 2).$theme[11]."\n";
                } else {
                    $output .= '';
                }
                $output .= $theme[13].str_pad(' '.$key.' ', $key_width + 2, ' ').$theme[12].str_pad(' '.$val.' ', $val_width + 2, ' ', (is_numeric($val) ? STR_PAD_LEFT : STR_PAD_RIGHT)).$theme[13]."\n";
                $output .= $theme[10].str_repeat($theme[1], $key_width + 2).$theme[14].str_repeat($theme[1], $val_width + 2).$theme[11]."\n";
            } else {
                if ($height > 0) {
                    $rows1 = explode("\n", $key);
                    $rows2 = explode("\n", $val);
                    for ($a = 0; $a < $height; $a++) {
                        $line = $theme[13].$this->mb_str_pad(' '.trim(@$rows1[$a], "\r\n").' ', $key_width + 2, ' ').$theme[12].$this->mb_str_pad(' '.trim(@$rows2[$a], "\r\n").' ', $val_width + 2, ' ', (is_numeric($val) ? STR_PAD_LEFT : STR_PAD_RIGHT)).$theme[13]."\n";
                        if (!empty(trim($line))) {
                            $output .= $line;
                        }
                    }
                } else {
                    $output .= $theme[13].str_pad(' '.$key.' ', $key_width + 2, ' ').$theme[12].str_pad(' '.$val.' ', $val_width + 2, ' ', (is_numeric($val) ? STR_PAD_LEFT : STR_PAD_RIGHT)).$theme[13]."\n";
                }
            }
        }
        if (!in_array($use_theme, $min_themes)) {
            $output .= $theme[4].str_repeat($theme[1], $key_width + 2).$theme[7].str_repeat($theme[1], $val_width + 2).$theme[5]."\n";
        }
        $isCLI = (php_sapi_name() == 'cli');
        if ($boldheaders && !in_array($use_theme, ['wrap', 'format'])) {
            //array_filter($tobold);
            foreach ($tobold as $bold) {
                if (!empty(trim($bold))) {
                    if ($isCLI) {
                        $output = str_replace($bold, $this->colorize($bold, 'bold'), $output);
                    } else {
                        $output = str_replace($bold, "<b>$bold</b>", $output);
                    }
                }
            }
        }

        return $output;
    }

    /**
     * @param        $str
     * @param string $style
     *
     * @return string
     */
    public function colorize($str, $style = 'yellow', $type = 'reset')
    {
        $styles = [
             'none'             => null,
             'bold'             => '1',
             'dark'             => '2',
             'italic'           => '3',
             'underline'        => '4',
             'blink'            => '5',
             'reverse'          => '7',
             'concealed'        => '8',
             'default'          => '39',
             'black'            => '30',
             'red'              => '31',
             'green'            => '32',
             'yellow'           => '33',
             'blue'             => '34',
             'magenta'          => '35',
             'cyan'             => '36',
             'light_gray'       => '37',
             'dark_gray'        => '90',
             'light_red'        => '91',
             'light_green'      => '92',
             'light_yellow'     => '93',
             'light_blue'       => '94',
             'light_magenta'    => '95',
             'light_cyan'       => '96',
             'white'            => '97',
             'bg_default'       => '49',
             'bg_black'         => '40',
             'bg_red'           => '41',
             'bg_green'         => '42',
             'bg_yellow'        => '43',
             'bg_blue'          => '44',
             'bg_magenta'       => '45',
             'bg_cyan'          => '46',
             'bg_light_gray'    => '47',
             'iblack'           => '90',
             'ired'             => '91',
             'igreen'           => '92',
             'iyellow'          => '93',
             'iblue'            => '94',
             'ipurple'          => '95',
             'icyan'            => '96',
             'iwhite'           => '97',
             'bg_dark_gray'     => '100',
             'bg_light_red'     => '101',
             'bg_light_green'   => '102',
             'bg_light_yellow'  => '103',
             'bg_light_blue'    => '104',
             'bg_light_magenta' => '105',
             'bg_light_cyan'    => '106',
             'bg_white'         => '107',
         ];
        $types = [
             'reset' => 0, 'bold' => 1, 'underline' => 4,
        ];
        $disptype = $types[$type];
        $value = 0;
        if (array_key_exists($style, $styles)) {
            $value = "\033[$disptype;".$styles[$style].'m';
        } else {
            return 'color not supported';
        }

        return $value.$str."\033[0;0m";
    }

    /**
     * @param $done
     * @param $total
     *
     *      do a console progress bar.
     */
    public function progressBar($done, $total)
    {
        $perc = floor(($done / $total) * 100);
        $left = 100 - $perc;
        $write = $this->colorize(sprintf("\033[0G\033[2K[%'={$perc}s>%-{$left}s] - $perc%% - $done/$total", '', ''), 'light_gray');
        fwrite(STDERR, $write);
    }

    /**
     *  ################## ################## ################## ################## ################## ##################
     *  BELOW is older code I wrote long long ago (like 2003-2005 range) for doing graphs in terminals
     *  ################## ################## ################## ################## ################## ##################.
     */

    /*
       remove flatspots in array..
       areas where the data does not change.
       this is good for data that only changes during certain times
       and the dead time has no bearing on the changes.
       -joeldg
    */
    public function remove_flatspots($arr, $pkey = true)
    {
        $oldval = 0;
        $ret = [];
        while (list($key, $val) = each($arr)) {
            if ($val != $oldval) {
                if ($pkey == true) {
                    $ret[$key] = $val;
                } else {
                    $ret[] = $val;
                }
            }
            $oldval = $val;
        }

        return $ret;
    }

    /*
       take two arrays, remove the flatspots in the first.
       return an array containing the first with it's corresponding
       values in the second array..
       -joeldg
    */
    public function dual_remove_flatspots($arr1, $arr2, $pkey = true)
    {
        $oldval = 0;
        while (list($key, $val) = each($arr1)) {
            if ($val != $oldval) {
                if ($pkey == true) {
                    $ret[0][$key] = $val;
                    $ret[1][$key] = $arr2[$key];
                } else {
                    $ret[0][] = $val;
                    $ret[1][] = $arr2[$key];
                }
            }
            $oldval = $val;
        }

        return $ret;
    }

    // return lowest val of array -joeldg
    public function least($inarr)
    {
        $ret = $inarr[0];
        for ($i = 0; $i < count($inarr); $i++) {
            if (intval($inarr[$i]) <= $ret) {
                $ret = $inarr[$i];
            }
        }//rof
        return $ret;
    }

    // end function
    // return higest val of array -joeldg
    public function most($inarr)
    {
        $ret = 0;
        while (list($key, $val) = each($inarr)) {
            if ($ret == '') {
                $ret = $val;
            }
            if ($ret <= intval($val)) {
                $ret = $val;
            }
        }//rof
        return $ret;
    }

    // end function
    /*
     array normalize function
     -joeldg
    */
    public function normalize($arr, $LO = 0.01, $HI = 0.99)
    {
        $Min = +2147483647;
        $Max = -2147483647;
        for ($a = 0; $a < count($arr); $a++) {
            $Min = min($Min, $arr[$a]);
            $Max = max($Max, $arr[$a]);
        }
        $Mean = 0;
        for ($a = 0; $a < count($arr); $a++) {
            $div = $Max - $Min;
            if ($div == 0) {
                $div = 1;
            }
            $arr[$a] = (($arr[$a] - $Min) / ($div)) * ($HI - $LO) + $LO;
            $Mean += $arr[$a] / count($arr);
        }

        return $arr;
    }

    /*
     array normalize function, preserve key
     -joeldg
    */
    public function normalizekey($arr, $LO = 0.01, $HI = 0.99)
    {
        $Min = +2147483647;
        $Max = -2147483647;
        while (list($key, $a) = each($arr)) {
            $Min = min($Min, $arr[$key]);
            $Max = max($Max, $arr[$key]);
        }
        reset($arr);
        $Mean = 0;
        while (list($key, $a) = each($arr)) {
            $div = $Max - $Min;
            if ($div == 0) {
                $div = 1;
            }
            $arr[$key] = (($arr[$key] - $Min) / ($div)) * ($HI - $LO) + $LO;
            $Mean += $arr[$key] / count($arr);
        }
        $retarr[0] = $arr;
        $retarr[1][0] = $Max;
        $retarr[1][1] = $Min;

        return $retarr;
    }

    /*
    display a textual graph in an xterm.
    written because I want to view timeseries data and not have to jump over to a browser.
    */
    //
    //    transform an array point to a position within the total
    //
    public function point2arr($point, $total = 20)
    {
        $p = round($point);
        $ret = [];
        for ($a = 0; $a < $total; $a++) {
            if ($a <= $p) {
                $ret[] = '%'; //chr(127);
            } else {
                $ret[] = ' ';
            }
        }

        return $ret;
    }

    // get the width and height of a unix terminal
    public function get_term_specs()
    {
        $b = `stty -a`;
        $c = explode("\n", $b);
        $d = explode(';', $c[0]);
        $f = explode(' ', $d[1]);
        $ret[h] = $f[2];
        $f = explode(' ', $d[2]);
        $ret[w] = intval($f[2]);

        return $ret;
    }

    public function genchars($char, $total, $title = '', $echo = false, $way = STR_PAD_RIGHT)
    {
        $ret = ' +';
        $back = $title;
        $ret .= str_pad($back, $total + strlen($back) - strlen($title) - 2, $char, $way);
        $ret .= '+';

        return $ret;
    }

    // vertical graph
    public function print_vert_graph($arr, $total = 20, $border = '-')
    {
        $arr = $this->normalize($arr, 0, $total);
        $out[] = $this->genchars($border, $total);
        for ($a = 0; $a < count($arr); $a++) {
            $out[] = $this->point2arr($arr[$a], $total);
        }
        $out[] = $this->genchars($border, $total);
        for ($a = 0; $a < count($out); $a++) {
            for ($b = 0; $b < count($out[$a]); $b++) {
                echo $out[$a][$b];
            }
            echo "\n";
        }
    }

    // transform matrix
    public function transformmat($arr, $total = 20)
    {
        $ret = [];
        $width = count($arr[0]);
        $c = $width - 1;
        for ($w = 0; $w < $width; $w++) {
            for ($a = 0; $a < count($arr); $a++) {
                $ret[$c][$a] = $arr[$a][$w];
            }
            $c--;
        }

        return $ret;
    }

    // horizontal graphing
    public function print_horz_graph($arr, $total = 20, $border = '-', $title = '', $w = '')
    {
        $ret = '';
        if ($w != '') {
            array_reverse($arr);
            $end = count($arr) - 1;
            reset($arr);
            while (list($key, $val) = each($arr)) {
                $newarr[] = $arr[$key];
                $end--;
                if ($end <= 0) {
                    break;
                }
            }
            $arr = $newarr;
        }
        $bottom = 'high: '.$this->most($arr).', low: '.$this->least($arr);
        $arr = $this->normalize($arr, 0, $total - 2);
        for ($a = 0; $a < count($arr); $a++) {
            $out[] = $this->point2arr($arr[$a], $total);
        }

        $out = $this->transformmat($out, $total);
        $ret .= $this->genchars('-', count($out[0]) + 2, $title, false);
        $ret .= "\n";
        for ($a = 0; $a < count($out); $a++) {
            $ret .= ' |';
            for ($b = 0; $b < count($out[$a]); $b++) {
                $ret .= $out[$a][$b];
            }
            $ret .= '|';
            $ret .= "\n";
        }
        $ret .= $this->genchars('-', count($out[0]) + 2, $bottom, false, STR_PAD_LEFT);
        $ret .= "\n";

        return $ret;
    }

    /*
     *  example of use
     *
        $testarr_z = array();
        $testarr = array();
        $qcount = 0;
        $start = microtime(true);

        while(1){
            $hw = get_term_specs();
            array_pad($testarr_z, ($hw['w'] - 6), 0);
            array_pad($testarr, ($hw['w'] - 6), 0);

            $qcount++;
            $testarr_z[] = rand(0,100);

            if(count($testarr_z)> ($hw['w'] - 6)){
                array_shift($testarr_z);
            }

            $testarr = normalize($testarr_z, 1, 100);
            $testarr = remove_flatspots($testarr, false);
            $tottime = $time_end - $start;
            $qps = round($qcount/$tottime);
            echo print_horz_graph($testarr, $hw['h']-3, "-", "local : $qcount queries/sec $qps", $hw['w']-1);
        }
     //*/
}
