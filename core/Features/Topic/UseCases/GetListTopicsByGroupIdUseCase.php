<?php

namespace Core\Features\Topic\UseCases;

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

        return Topic::getCachedRepo()->getByGroupId($model->id);
    }
}
