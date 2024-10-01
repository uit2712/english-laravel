<?php

namespace Core\Features\Group\Facades;

use Core\Features\Group\UseCases\GetGroupByIdUseCase;
use Core\Features\Group\UseCases\GetListTopicsByGroupIdUseCase;
use Core\Features\Group\UseCases\GetMultipleGroupsUseCase;
use Core\Features\Group\UseCases\ResetTableGroupUseCase;
use Core\Features\Group\ViewModels\GetGroupByIdViewModel;
use Core\Features\Group\ViewModels\GetListTopicsByGroupIdViewModel;
use Core\Features\Group\ViewModels\GetMultipleGroupsViewModel;

class GroupApi
{
    /**
     * @var GetGroupByIdUseCase|null
     */
    private static $getGroupByIdUseCase;

    /**
     * @var ResetTableGroupUseCase|null
     */
    private static $resetTableGroupUseCase;

    /**
     * @var GetListTopicsByGroupIdUseCase|null
     */
    public static $getListTopicsByGroupIdUseCase;

    /**
     * @var GetMultipleGroupsUseCase|null
     */
    public static $getMultipleGroupsUseCase;

    public static function getById($id)
    {
        $model = new GetGroupByIdViewModel($id);

        if (null == self::$getGroupByIdUseCase) {
            self::$getGroupByIdUseCase = new GetGroupByIdUseCase();
        }

        return self::$getGroupByIdUseCase->invoke($model);
    }

    public static function resetTable()
    {
        if (null == self::$resetTableGroupUseCase) {
            self::$resetTableGroupUseCase = new ResetTableGroupUseCase();
        }

        return self::$resetTableGroupUseCase->invoke();
    }

    /**
     * @param int $groupId Group id.
     */
    public static function getListTopicsById($id)
    {
        $model = new GetListTopicsByGroupIdViewModel($id);

        if (null == self::$getListTopicsByGroupIdUseCase) {
            self::$getListTopicsByGroupIdUseCase = new GetListTopicsByGroupIdUseCase();
        }

        return self::$getListTopicsByGroupIdUseCase->invoke($model);
    }

    /**
     * @param string|int|null $pageIndex Page index.
     * @param string|int|null $perPage Per page.
     */
    public static function getMultiple($pageIndex, $perPage)
    {
        $model = new GetMultipleGroupsViewModel($pageIndex, $perPage);

        if (null == self::$getMultipleGroupsUseCase) {
            self::$getMultipleGroupsUseCase = new GetMultipleGroupsUseCase();
        }

        return self::$getMultipleGroupsUseCase->invoke($model);
    }
}
