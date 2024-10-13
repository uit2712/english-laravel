<?php

namespace Core\Features\Vocabulary\UseCases;

use Core\Features\Vocabulary\Facades\Vocabulary;

class GetVocabularyByIdUseCase
{
    /**
     * @param string|null $id Id.
     */
    public function invoke($id)
    {
        return Vocabulary::getCachedRepo()->get($id);
    }
}
