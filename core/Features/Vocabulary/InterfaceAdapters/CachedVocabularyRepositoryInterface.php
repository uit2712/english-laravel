<?php

namespace Core\Features\Vocabulary\InterfaceAdapters;

use Core\Features\Vocabulary\Models\GetListVocabulariesResult;
use Core\Features\Vocabulary\Models\GetVocabularyResult;

interface CachedVocabularyRepositoryInterface
{
    /**
     * @param int|null $id Id.
     */
    public function get($id): GetVocabularyResult;
    /**
     * @param int|null $topicId Topic id.
     */
    public function getByTopicId($topicId): GetListVocabulariesResult;
}
