<?php

namespace Core\Features\File\Facades;

use Core\Features\File\UseCases\ReadCsvFileUseCase;

class CsvFileApi
{
    /**
     * @var ReadCsvFileUseCase|null
     */
    private static $readCsvFileUseCase;

    public static function read($filePath)
    {
        if (null === self::$readCsvFileUseCase) {
            self::$readCsvFileUseCase = new ReadCsvFileUseCase();
        }

        return self::$readCsvFileUseCase->invoke($filePath);
    }
}
