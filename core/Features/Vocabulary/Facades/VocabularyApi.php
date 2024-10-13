<?php

namespace Core\Features\Vocabulary\Facades;

use Core\Features\Vocabulary\UseCases\CheckTableVocabularyExistUseCase;

class VocabularyApi
{
    /**
     * @var CheckTableVocabularyExistUseCase|null
     */
    private static $checkTableVocabularyExistUseCase;

    public static function isTableExisted()
    {
        if (null == self::$checkTableVocabularyExistUseCase) {
            self::$checkTableVocabularyExistUseCase = new CheckTableVocabularyExistUseCase();
        }

        return self::$checkTableVocabularyExistUseCase->invoke();
    }
}
