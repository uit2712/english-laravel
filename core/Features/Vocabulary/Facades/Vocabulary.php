<?php

namespace Core\Features\Vocabulary\Facades;

use Core\Features\Vocabulary\InterfaceAdapters\CachedVocabularyRepositoryInterface;
use Core\Features\Vocabulary\InterfaceAdapters\VocabularyFileMapperInterface;
use Core\Features\Vocabulary\InterfaceAdapters\VocabularyMapperInterface;
use Core\Features\Vocabulary\InterfaceAdapters\VocabularyRepositoryInterface;
use Core\Features\Vocabulary\Mappers\VocabularyFileMapper;
use Core\Features\Vocabulary\Mappers\VocabularyMapper;
use Core\Features\Vocabulary\Repositories\CachedVocabularyRepository;
use Core\Features\Vocabulary\Repositories\VocabularyRepository;

class Vocabulary
{
    /**
     * @var VocabularyMapperInterface|null
     */
    private static $mapper;

    /**
     * @var VocabularyRepositoryInterface|null
     */
    private static $repo;

    /**
     * @var CachedVocabularyRepositoryInterface|null
     */
    private static $cachedRepo;

    /**
     * @var VocabularyFileMapperInterface|null
     */
    private static $fileMapper;

    public static function getMapper(): VocabularyMapperInterface
    {
        if (null == self::$mapper) {
            self::$mapper = new VocabularyMapper();
        }

        return self::$mapper;
    }

    public static function getRepo(): VocabularyRepositoryInterface
    {
        if (null == self::$repo) {
            self::$repo = new VocabularyRepository();
        }

        return self::$repo;
    }

    public static function getCachedRepo(): CachedVocabularyRepositoryInterface
    {
        if (null == self::$cachedRepo) {
            self::$cachedRepo = new CachedVocabularyRepository();
        }

        return self::$cachedRepo;
    }

    public static function getFileMapper(): VocabularyFileMapperInterface
    {
        if (null == self::$fileMapper) {
            self::$fileMapper = new VocabularyFileMapper();
        }

        return self::$fileMapper;
    }
}
