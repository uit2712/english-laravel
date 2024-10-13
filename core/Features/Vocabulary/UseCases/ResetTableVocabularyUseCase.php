<?php

namespace Core\Features\Vocabulary\UseCases;

use Core\Features\Vocabulary\Facades\Vocabulary;

class ResetTableVocabularyUseCase
{
    public function invoke()
    {
        return Vocabulary::getRepo()->reset();
    }
}
