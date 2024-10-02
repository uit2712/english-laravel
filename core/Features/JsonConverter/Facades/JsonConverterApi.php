<?php

namespace Core\Features\JsonConverter\Facades;

use Core\Features\JsonConverter\UseCases\DecodeStringToJsonUseCase;

class JsonConverterApi
{
    /**
     * @var DecodeStringToJsonUseCase|null
     */
    private static $decodeStringToJsonUseCase;

    /**
     * @param string|null $value Value.
     */
    public static function decode($value)
    {
        if (null === self::$decodeStringToJsonUseCase) {
            self::$decodeStringToJsonUseCase = new DecodeStringToJsonUseCase();
        }

        return self::$decodeStringToJsonUseCase->invoke($value);
    }
}
