<?php

namespace Core\Features\Group\UseCases;

use Core\Features\Group\Facades\Group;

class ResetTableGroupUseCase
{
    public function invoke()
    {
        return Group::getRepo()->reset();
    }
}
