<?php

namespace Core\Features\FilePath\Facades;

use Core\Features\FilePath\InterfaceAdapters\FilePathRepositoryInterface;
use Framework\Features\FilePath\Repositories\FilePathRepository;

class FilePath
{
    /**
     * @var FilePathRepositoryInterface|null
     */
    private static $repo;

    public static function getRepo()
    {
        if (null === self::$repo) {
            self::$repo = new FilePathRepository();
        }

        return self::$repo;
    }
}
