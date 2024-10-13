<?php

namespace Core\Features\Topic\Facades;

use Core\Features\Topic\UseCases\GetListVocabulariesByTopicIdUseCase;
use Core\Features\Topic\UseCases\GetTopicByIdUseCase;
use Core\Features\Topic\UseCases\ReadListTopicsFromCsvFileUseCase;
use Core\Features\Topic\UseCases\ResetTableTopicUseCase;
use Core\Features\Topic\ViewModels\GetListVocabulariesByTopicIdViewModel;
use Core\Features\Topic\ViewModels\GetTopicByIdViewModel;

class TopicApi
{
    /**
     * @var GetTopicByIdUseCase|null
     */
    private static $getTopicByIdUseCase;

    /**
     * @var ResetTableTopicUseCase|null
     */
    private static $resetTableTopicUseCase;

    /**
     * @var ReadListTopicsFromCsvFileUseCase|null
     */
    private static $readListTopicsFromCsvFileUseCase;

    /**
     * @var GetListVocabulariesByTopicIdUseCase|null
     */
    private static $getListVocabulariesByTopicIdUseCase;

    public static function getById($id)
    {
        $model = new GetTopicByIdViewModel($id);

        if (null == self::$getTopicByIdUseCase) {
            self::$getTopicByIdUseCase = new GetTopicByIdUseCase();
        }

        return self::$getTopicByIdUseCase->invoke($model);
    }

    public static function resetTable()
    {
        if (null == self::$resetTableTopicUseCase) {
            self::$resetTableTopicUseCase = new ResetTableTopicUseCase();
        }

        return self::$resetTableTopicUseCase->invoke();
    }

    public static function readFromCsvFile()
    {
        if (null == self::$readListTopicsFromCsvFileUseCase) {
            self::$readListTopicsFromCsvFileUseCase = new ReadListTopicsFromCsvFileUseCase();
        }

        return self::$readListTopicsFromCsvFileUseCase->invoke();
    }

    /**
     * @param int $id Id.
     */
    public static function getListVocabulariesById($id)
    {
        $model = new GetListVocabulariesByTopicIdViewModel($id);

        if (null === self::$getListVocabulariesByTopicIdUseCase) {
            self::$getListVocabulariesByTopicIdUseCase = new GetListVocabulariesByTopicIdUseCase();
        }

        return self::$getListVocabulariesByTopicIdUseCase->invoke($model);
    }
}
