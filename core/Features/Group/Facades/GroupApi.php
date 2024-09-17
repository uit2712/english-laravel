<?php

namespace Core\Features\Group\Facades;

use Core\Features\Group\UseCases\GetAllGroupsUseCase;
use Core\Features\Group\UseCases\GetGroupByIdUseCase;
use Core\Features\Group\ViewModels\GetGroupByIdViewModel;

class GroupApi
{
    /**
     * @var GetAllGroupsUseCase|null
     */
    public static $getAllGroupsUseCase;

    /**
     * @var GetGroupByIdUseCase|null
     */
    public static $getGroupByIdUseCase;

    public static function getAll()
    {
        if (null == self::$getAllGroupsUseCase) {
            self::$getAllGroupsUseCase = new GetAllGroupsUseCase();
        }

        return self::$getAllGroupsUseCase->invoke();
    }

    public static function getById($id)
    {
        $model = new GetGroupByIdViewModel($id);

        if (null == self::$getGroupByIdUseCase) {
            self::$getGroupByIdUseCase = new GetGroupByIdUseCase();
        }

        return self::$getGroupByIdUseCase->invoke($model);
    }
}
