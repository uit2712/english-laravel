<?php

namespace Core\Features\Group\UseCases;

use Core\Features\Group\Facades\Group;
use Core\Features\Group\ViewModels\GetMultipleGroupsViewModel;

class GetMultipleGroupsUseCase
{
    /**
     * @param GetMultipleGroupsViewModel $model Model.
     */
    public function invoke($model)
    {
        $validateResult = $model->validate();
        if (false === $validateResult->success) {
            return $validateResult;
        }

        return Group::getCachedRepo()->getMultiple($model->pageIndex, $model->perPage);
    }
}
