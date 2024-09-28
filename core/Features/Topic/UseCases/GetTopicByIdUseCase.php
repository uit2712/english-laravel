<?php

namespace Core\Features\Topic\UseCases;

use Core\Features\Topic\Facades\Topic;
use Core\Features\Topic\ViewModels\GetTopicByIdViewModel;

class GetTopicByIdUseCase
{
    /**
     * @param GetTopicByIdViewModel $model Model.
     */
    public function invoke($model)
    {
        $validateResult = $model->validate();
        if (false === $validateResult->success) {
            return $validateResult;
        }

        return Topic::getCachedRepo()->get($model->id);
    }
}
