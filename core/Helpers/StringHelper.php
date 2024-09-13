<?php

namespace Core\Helpers;

class StringHelper
{
    public static function isValid($value)
    {
        return is_string($value);
    }

    public static function isHasValue($value)
    {
        return self::isValid($value) && empty(trim($value)) === false;
    }

    /**
     * @param string|null $value Value.
     * @param mixed       $defaultValue Default value.
     */
    public static function trim($value, $defaultValue = '')
    {
        return is_string($value) ? trim($value) : $defaultValue;
    }

    /**
     * Remove characters: `\r`, `\n`, `\b`, `\t`
     *
     * @param string|null $value Value.
     */
    public static function removeSpecialChars($value)
    {
        if (self::isHasValue($value) === false) {
            return '';
        }

        return preg_replace('/[\r|\n|\b|\t]/', '', $value);
    }

    public static function isHasValueWithoutTrim($value)
    {
        return self::isValid($value) && empty($value) === false;
    }

    public static function random($length = 20)
    {
        if (NumberHelper::isPositiveInteger($length) === false) {
            $length = 20;
        }

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[ random_int(0, $charactersLength - 1) ];
        }

        return $randomString;
    }
}
