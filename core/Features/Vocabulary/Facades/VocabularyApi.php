<?php

namespace Core\Features\Vocabulary\Facades;

use Core\Features\Vocabulary\UseCases\CheckTableVocabularyExistUseCase;
use Core\Features\Vocabulary\UseCases\GetVocabularyByIdUseCase;
use Core\Features\Vocabulary\UseCases\ReadListVocabulariesFromCsvFileUseCase;

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

    /**
     * @var ReadListVocabulariesFromCsvFileUseCase|null
     */
    private static $readListVocabulariesFromCsvFileUseCase;

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
    public static function getById($id)
    {
        if (null == self::$getVocabularyByIdUseCase) {
            self::$getVocabularyByIdUseCase = new GetVocabularyByIdUseCase();
        }

        return self::$getVocabularyByIdUseCase->invoke($id);
    }

    public static function readFromCsvFile()
    {
        if (null == self::$readListVocabulariesFromCsvFileUseCase) {
            self::$readListVocabulariesFromCsvFileUseCase = new ReadListVocabulariesFromCsvFileUseCase();
        }

        return self::$readListVocabulariesFromCsvFileUseCase->invoke();
    }
}
