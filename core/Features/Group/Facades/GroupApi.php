<?php

namespace Core\Features\Group\Facades;

use Core\Features\Group\UseCases\GetAllGroupsUseCase;

class GroupApi
{
    /**
     * @var GetAllGroupsUseCase|null
     */
    public static $getAllGroupsUseCase;

    public static function getAll()
    {
        if (null == self::$getAllGroupsUseCase) {
            self::$getAllGroupsUseCase = new GetAllGroupsUseCase();
        }

        return self::$getAllGroupsUseCase->invoke();
    }
}
