<?php

namespace Core\Features\Vocabulary\InterfaceAdapters;

use Core\Features\Vocabulary\Models\GetVocabularyResult;

interface VocabularyRepositoryInterface
{
    public function isTableExisted(): bool;
    public function get($id): GetVocabularyResult;
}
