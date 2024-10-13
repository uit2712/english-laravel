<?php

namespace Core\Features\Vocabulary\InterfaceAdapters;

use Core\Features\Vocabulary\Models\GetListVocabulariesResult;
use Core\Features\Vocabulary\Models\GetVocabularyResult;
use Core\Models\Result;

interface VocabularyRepositoryInterface
{
    public function isTableExisted(): bool;
    /**
     * @param int|null $id Id.
     */
    public function get($id): GetVocabularyResult;
    public function reset(): Result;
    /**
     * @param int|null $topicId Topic id.
     */
    public function getByTopicId($topicId): GetListVocabulariesResult;
}
