<?php

namespace Core\Features\FilePath\Facades;

use Core\Features\FilePath\UseCases\GetBasePathUseCase;

class FilePathApi
{
    /**
     * @var GetBasePathUseCase|null
     */
    private static $getBasePathUseCase;

    public static function getBasePath()
    {
        if (null === self::$getBasePathUseCase) {
            self::$getBasePathUseCase = new GetBasePathUseCase();
        }

        return self::$getBasePathUseCase->invoke();
    }
}
