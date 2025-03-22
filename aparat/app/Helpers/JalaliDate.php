<?php

namespace App\Helpers;

use Morilog\Jalali\Jalalian;

class JalaliDate
{
    public static function toJalaliDate($date)
    {
        return Jalalian::fromDateTime($date)->format('Y/m/d');
    }

}
