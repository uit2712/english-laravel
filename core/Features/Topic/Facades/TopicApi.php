<?php

namespace Core\Features\Topic\Facades;

use Core\Features\Topic\UseCases\GetAllTopicsUseCase;
use Core\Features\Topic\UseCases\GetTopicByIdUseCase;
use Core\Features\Topic\UseCases\ResetTableTopicUseCase;
use Core\Features\Topic\ViewModels\GetTopicByIdViewModel;

class TopicApi
{
    /**
     * @var GetTopicByIdUseCase|null
     */
    public static $getTopicByIdUseCase;

    /**
     * @var ResetTableTopicUseCase|null
     */
    public static $resetTableTopicUseCase;

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
}
