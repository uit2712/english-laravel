<?php

namespace Core\Features\Vocabulary\UseCases;

use Core\Features\Vocabulary\Facades\Vocabulary;
use Core\Features\Vocabulary\ViewModels\GetVocabularyByIdViewModel;

class GetVocabularyByIdUseCase
{
    /**
     * @param GetVocabularyByIdViewModel $model Model.
     */
    public function invoke($model)
    {
        $validateResult = $model->validate();
        if (false === $validateResult->success) {
            return $validateResult;
        }

        return Vocabulary::getCachedRepo()->get($model->id);
    }
}
