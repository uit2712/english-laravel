<?php

namespace Core\Features\Group\Facades;

use Core\Features\Group\InterfaceAdapters\CachedGroupRepositoryInterface;
use Core\Features\Group\InterfaceAdapters\GroupMapperInterface;
use Core\Features\Group\InterfaceAdapters\GroupRepositoryInterface;
use Core\Features\Group\Mappers\GroupMapper;
use Core\Features\Group\Repositories\CachedGroupRepository;
use Core\Features\Group\Repositories\GroupRepository;

class Group
{
    /**
     * @var GroupMapperInterface|null
     */
    private static $mapper;

    /**
     * @var GroupRepositoryInterface|null
     */
    private static $repo;

    /**
     * @var CachedGroupRepositoryInterface|null
     */
    private static $cachedRepo;

    public static function getMapper(): GroupMapperInterface
    {
        if (null == self::$mapper) {
            self::$mapper = new GroupMapper();
        }

        return self::$mapper;
    }

    public static function getRepo(): GroupRepositoryInterface
    {
        if (null == self::$repo) {
            self::$repo = new GroupRepository();
        }

        return self::$repo;
    }

    public static function getCachedRepo(): CachedGroupRepositoryInterface
    {
        if (null == self::$cachedRepo) {
            self::$cachedRepo = new CachedGroupRepository();
        }

        return self::$cachedRepo;
    }
}
