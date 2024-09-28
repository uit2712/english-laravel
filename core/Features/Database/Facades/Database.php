<?php

namespace Core\Features\Database\Facades;

use Core\Features\Database\InterfaceAdapters\DatabaseRepositoryInterface;
use Exception;
use Framework\Features\Database\Repositories\DatabaseRepository;

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
        try {
            return self::getRepo()->select($queryStr);
        } catch (Exception $ex) {
            return [];
        }
    }

    /**
     * @param string $queryStr Query string.
     */
    public static function selectOne($queryStr)
    {
        try {
            return self::getRepo()->selectOne($queryStr);
        } catch (Exception $ex) {
            return null;
        }
    }

    /**
     * @param string $queryStr Query string.
     */
    public static function query($queryStr): mixed
    {
        try {
            return self::getRepo()->query($queryStr);
        } catch (Exception $ex) {
            return null;
        }
    }

    /**
     * @param string $tableName Table name.
     */
    public static function truncate($tableName): mixed
    {
        try {
            return self::getRepo()->truncate($tableName);
        } catch (Exception $ex) {
            return null;
        }
    }
}
