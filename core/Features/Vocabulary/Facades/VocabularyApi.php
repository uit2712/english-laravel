<?php

namespace Core\Features\Vocabulary\Facades;

use Core\Features\Vocabulary\UseCases\CheckTableVocabularyExistUseCase;
use Core\Features\Vocabulary\UseCases\GetVocabularyByIdUseCase;

class VocabularyApi
{
    /**
     * @var CheckTableVocabularyExistUseCase|null
     */
    private static $checkTableVocabularyExistUseCase;

    /**
     * @var GetVocabularyByIdUseCase|null
     */
    private static $getVocabularyByIdUseCase;

    public static function isTableExisted()
    {
        if (null == self::$checkTableVocabularyExistUseCase) {
            self::$checkTableVocabularyExistUseCase = new CheckTableVocabularyExistUseCase();
        }

        return self::$checkTableVocabularyExistUseCase->invoke();
    }

    /**
     * @param string|null $id Id.
     */
    public static function get($id)
    {
        if (null == self::$getVocabularyByIdUseCase) {
            self::$getVocabularyByIdUseCase = new GetVocabularyByIdUseCase();
        }

        return self::$getVocabularyByIdUseCase->invoke($id);
    }
}
