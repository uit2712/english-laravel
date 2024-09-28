<?php

namespace Core\Features\Cache\Facades;

use Core\Features\Cache\UseCases\CheckCacheConnectionUseCase;
use Core\Features\Cache\UseCases\FlushAllCacheUseCase;

class CustomCacheApi
{
    /**
     * @var FlushAllCacheUseCase|null
     */
    private static $flushAllCacheUseCase;

    /**
     * @var CheckCacheConnectionUseCase|null
     */
    private static $checkCacheConnectionUseCase;

    public static function flushAll()
    {
        if (null === self::$flushAllCacheUseCase) {
            self::$flushAllCacheUseCase = new FlushAllCacheUseCase();
        }

        return self::$flushAllCacheUseCase->invoke();
    }

    public static function checkConnection()
    {
        if (null === self::$checkCacheConnectionUseCase) {
            self::$checkCacheConnectionUseCase = new CheckCacheConnectionUseCase();
        }

        return self::$checkCacheConnectionUseCase->invoke();
    }
}
