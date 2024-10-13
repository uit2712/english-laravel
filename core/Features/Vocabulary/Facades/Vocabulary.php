<?php

namespace Core\Features\Vocabulary\Facades;

use Core\Features\Vocabulary\InterfaceAdapters\VocabularyMapperInterface;
use Core\Features\Vocabulary\InterfaceAdapters\VocabularyRepositoryInterface;
use Core\Features\Vocabulary\Mappers\VocabularyMapper;
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
}
