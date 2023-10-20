<?php


namespace App\Helpers;


use Illuminate\Support\Carbon;

class Formatter
{
    public static function number($txt)
    {
        $dot        = '.';
        $decZero    = '0000';

        if (!is_null($txt) && strlen($txt) > 0) {
            $txt    = explode($dot, $txt);
            $int    = $txt[0];
            $dec    = $txt[1];

            $txt = strpos($dec, $decZero) ? number_format($int) 
                                            : number_format($int) . $dot . $dec;
        }

        $txt = sprintf('%g', $txt);

        return $txt;
    }

    public static function date($txt, $format = 'Y/m/d')
    {
        return Carbon::parse($txt)->format($format);
    }

}
