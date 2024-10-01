<?php

namespace Core\Features\File\Facades;

use Core\Features\File\InterfaceAdapters\CsvFileRepositoryInterface;
use Core\Features\File\Repositories\CsvFileRepository;

class CsvFile
{
    /**
     * @var CsvFileRepositoryInterface|null
     */
    private static $repo;

    public static function getRepo()
    {
        if (null === self::$repo) {
            self::$repo = new CsvFileRepository();
        }

        return self::$repo;
    }
}
