<?php

namespace Core\Features\Topic\UseCases;

use Core\Features\Topic\Facades\TopicApi;
use Core\Features\Topic\ViewModels\GetListVocabulariesByTopicIdViewModel;
use Core\Features\Vocabulary\Facades\Vocabulary;

class GetListVocabulariesByTopicIdUseCase
{
    /**
     * @param GetListVocabulariesByTopicIdViewModel $model Model.
     */
    public function invoke($model)
    {
        $validateResult = $model->validate();
        if (false === $validateResult->success) {
            return $validateResult;
        }

        $getTopicResult = TopicApi::getById($model->id);
        if (false === $getTopicResult->success) {
            return $getTopicResult;
        }

        return Vocabulary::getCachedRepo()->getByTopicId($model->id);
    }
}
