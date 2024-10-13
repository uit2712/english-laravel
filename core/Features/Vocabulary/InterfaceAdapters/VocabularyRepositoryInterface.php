<?php

namespace Core\Features\Vocabulary\InterfaceAdapters;

use Core\Features\Vocabulary\Models\GetVocabularyResult;
use Core\Models\Result;

interface VocabularyRepositoryInterface
{
    public function isTableExisted(): bool;
    public function get($id): GetVocabularyResult;
    public function reset(): Result;
}
