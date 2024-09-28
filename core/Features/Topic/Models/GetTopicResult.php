<?php

namespace Core\Features\Topic\Models;

use Core\Features\Topic\Entities\TopicEntity;
use Core\Models\Result;

class GetTopicResult extends Result
{
    /**
     * @var TopicEntity
     */
    public $data = null;
}
