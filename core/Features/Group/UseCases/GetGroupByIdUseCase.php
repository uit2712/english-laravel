<?php

namespace Core\Features\Group\UseCases;

use Core\Features\Group\Facades\Group;
use Core\Features\Group\ViewModels\GetGroupByIdViewModel;

class GetGroupByIdUseCase
{
    /**
     * @param GetGroupByIdViewModel $model Model.
     */
    public function invoke($model)
    {
        $validateResult = $model->validate();
        if (false === $validateResult->success) {
            return $validateResult;
        }

        return Group::getCachedRepo()->get($model->id);
    }
}
