<?php

namespace App\Support;

class FormatCurrency
{
    public static function toString(int $cents): string
    {
        return number_format($cents / 100, 2, '.', ',');
    }
}
