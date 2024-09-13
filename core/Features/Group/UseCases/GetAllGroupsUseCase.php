<?php

namespace Core\Features\Group\UseCases;

use Core\Features\Group\Facades\Group;

class GetAllGroupsUseCase
{
    public function invoke()
    {
        return Group::getRepo()->getAll();
    }
}
