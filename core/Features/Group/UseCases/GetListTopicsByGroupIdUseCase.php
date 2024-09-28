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

        $getGroupIdResult = GroupApi::getById($model->id);
        if (false === $getGroupIdResult->success) {
            return $getGroupIdResult;
        }

        return Topic::getCachedRepo()->getByGroupId($model->id);
    }
}
