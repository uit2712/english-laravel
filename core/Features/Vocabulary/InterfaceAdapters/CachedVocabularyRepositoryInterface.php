<?php

namespace Core\Features\Vocabulary\InterfaceAdapters;

use Core\Features\Vocabulary\Models\GetVocabularyResult;

interface CachedVocabularyRepositoryInterface
{
    public function get($id): GetVocabularyResult;
}
