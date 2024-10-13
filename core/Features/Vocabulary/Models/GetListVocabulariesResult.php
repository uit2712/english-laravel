<?php

namespace Core\Features\Vocabulary\Models;

use Core\Features\Vocabulary\Entities\VocabularyEntity;
use Core\Models\Result;

class GetListVocabulariesResult extends Result
{
    /**
     * @var VocabularyEntity[]
     */
    public $data = [];
}
