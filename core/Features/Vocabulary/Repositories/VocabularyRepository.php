<?php

namespace Core\Features\Vocabulary\Repositories;

use Core\Features\Database\Facades\Database;
use Core\Features\Vocabulary\Constants\VocabularyConstants;
use Core\Features\Vocabulary\InterfaceAdapters\VocabularyRepositoryInterface;

class VocabularyRepository implements VocabularyRepositoryInterface
{
    public function isTableExisted(): bool
    {
        return Database::isTableExisted(VocabularyConstants::TABLE_NAME);
    }
}
