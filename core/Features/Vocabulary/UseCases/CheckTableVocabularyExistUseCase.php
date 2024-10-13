<?php

namespace Core\Features\Vocabulary\UseCases;

use Core\Features\Vocabulary\Facades\Vocabulary;

class CheckTableVocabularyExistUseCase
{
    public function invoke()
    {
        return Vocabulary::getRepo()->isTableExisted();
    }
}
