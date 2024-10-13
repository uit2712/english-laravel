<?php

namespace Core\Features\Group\UseCases;

use Core\Features\Group\Facades\GroupApi;
use Core\Features\Topic\Facades\Topic;
use Core\Features\Topic\ViewModels\GetListTopicsByGroupIdViewModel;

class GetListTopicsByGroupIdUseCase
{
    /**
     * @param GetListTopicsByGroupIdViewModel $model Model.
     */
    public function invoke($model)
    {
        $validateResult = $model->validate();
        if (false === $validateResult->success) {
            return $validateResult;
        }

        $getGroupResult = GroupApi::getById($model->id);
        if (false === $getGroupResult->success) {
            return $getGroupResult;
        }

        return Topic::getCachedRepo()->getByGroupId($model->id);
    }
}
