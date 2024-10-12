<?php

namespace Core\Features\Topic\Facades;

use Core\Features\Topic\InterfaceAdapters\CachedTopicRepositoryInterface;
use Core\Features\Topic\InterfaceAdapters\TopicFileMapperInterface;
use Core\Features\Topic\InterfaceAdapters\TopicMapperInterface;
use Core\Features\Topic\InterfaceAdapters\TopicRepositoryInterface;
use Core\Features\Topic\Mappers\TopicFileMapper;
use Core\Features\Topic\Mappers\TopicMapper;
use Core\Features\Topic\Repositories\CachedTopicRepository;
use Core\Features\Topic\Repositories\TopicRepository;

class Topic
{
    /**
     * @var TopicMapperInterface|null
     */
    private static $mapper;

    /**
     * @var TopicRepositoryInterface|null
     */
    private static $repo;

    /**
     * @var CachedTopicRepositoryInterface|null
     */
    private static $cachedRepo;

    /**
     * @var TopicFileMapperInterface|null
     */
    private static $fileMapper;

    public static function getMapper(): TopicMapperInterface
    {
        if (null == self::$mapper) {
            self::$mapper = new TopicMapper();
        }

        return self::$mapper;
    }

    public static function getRepo(): TopicRepositoryInterface
    {
        if (null == self::$repo) {
            self::$repo = new TopicRepository();
        }

        return self::$repo;
    }

    public static function getCachedRepo(): CachedTopicRepositoryInterface
    {
        if (null == self::$cachedRepo) {
            self::$cachedRepo = new CachedTopicRepository();
        }

        return self::$cachedRepo;
    }

    public static function getFileMapper(): TopicFileMapperInterface
    {
        if (null == self::$fileMapper) {
            self::$fileMapper = new TopicFileMapper();
        }

        return self::$fileMapper;
    }
}
