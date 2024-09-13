<?php

namespace Core\Helpers;

class NumberHelper
{
    public static function isInteger($value)
    {
        return is_int($value);
    }

    public static function isPositiveInteger($value)
    {
        return self::isInteger($value) && $value > 0;
    }

    public static function isPositiveIntegerIncludeZero($value)
    {
        return self::isInteger($value) && $value >= 0;
    }
}
