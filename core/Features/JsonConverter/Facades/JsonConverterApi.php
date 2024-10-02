<?php

namespace Core\Features\JsonConverter\Facades;

use Core\Features\JsonConverter\UseCases\DecodeStringToJsonUseCase;
use Core\Features\JsonConverter\UseCases\EncodeJsonToStringUseCase;

class JsonConverterApi
{
    /**
     * @var DecodeStringToJsonUseCase|null
     */
    private static $decodeStringToJsonUseCase;

    /**
     * @var EncodeJsonToStringUseCase|null
     */
    private static $encodeJsonToStringUseCase;

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

    /**
     * @param mixed|null $value Value.
     */
    public static function encode($value)
    {
        if (null === self::$encodeJsonToStringUseCase) {
            self::$encodeJsonToStringUseCase = new EncodeJsonToStringUseCase();
        }

        return self::$encodeJsonToStringUseCase->invoke($value);
    }
}
