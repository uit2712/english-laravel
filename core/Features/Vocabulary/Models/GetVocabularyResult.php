<?php

namespace Core\Features\Vocabulary\Models;

use Core\Features\Vocabulary\Entities\VocabularyEntity;
use Core\Models\Result;

class GetVocabularyResult extends Result
{
    /**
     * @var VocabularyEntity
     */
    public $data = null;
}
