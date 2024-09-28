<?php

namespace Core\Features\Topic\Facades;

use Core\Features\Topic\UseCases\GetListTopicsByGroupIdUseCase;
use Core\Features\Topic\UseCases\GetTopicByIdUseCase;
use Core\Features\Topic\UseCases\ResetTableTopicUseCase;
use Core\Features\Topic\ViewModels\GetListTopicsByGroupIdViewModel;
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

    /**
     * @var GetListTopicsByGroupIdUseCase|null
     */
    public static $getListTopicsByGroupIdUseCase;

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

    /**
     * @param int $groupId Group id.
     */
    public static function getByGroupId($groupId)
    {
        $model = new GetListTopicsByGroupIdViewModel($groupId);

        if (null == self::$getListTopicsByGroupIdUseCase) {
            self::$getListTopicsByGroupIdUseCase = new GetListTopicsByGroupIdUseCase();
        }

        return self::$getListTopicsByGroupIdUseCase->invoke($model);
    }
}
