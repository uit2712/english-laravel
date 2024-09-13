<?php

namespace Core\Features\Database\Facades;

use Core\Features\Database\InterfaceAdapters\DatabaseRepositoryInterface;
use Frameworks\Features\Database\Repositories\DatabaseRepository;

class Database
{
    /**
     * @var DatabaseRepositoryInterface|null
     */
    public static $repo;

    private static function getRepo(): DatabaseRepositoryInterface
    {
        if (null == self::$repo) {
            self::$repo = new DatabaseRepository();
        }

        return self::$repo;
    }

    /**
     * @param string $queryStr Query string.
     */
    public static function select($queryStr)
    {
        return self::getRepo()->select($queryStr);
    }

    /**
     * @param string $queryStr Query string.
     */
    public static function selectOne($queryStr)
    {
        return self::getRepo()->selectOne($queryStr);
    }
}
