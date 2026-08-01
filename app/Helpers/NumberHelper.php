<?php

namespace App\Helpers;

use NumberFormatter;

class NumberHelper
{
    public static function amountInWords($number)
    {
        $formatter = new NumberFormatter('en_IN', NumberFormatter::SPELLOUT);

        return ucwords($formatter->format($number));
    }
}