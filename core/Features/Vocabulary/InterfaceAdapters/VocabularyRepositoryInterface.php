<?php

namespace Core\Features\Vocabulary\InterfaceAdapters;

interface VocabularyRepositoryInterface
{
    public function isTableExisted(): bool;
}
