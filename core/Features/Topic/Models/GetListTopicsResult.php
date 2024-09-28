<?php

namespace Core\Features\Topic\Models;

use Core\Features\Topic\Entities\TopicEntity;
use Core\Models\Result;

class GetListTopicsResult extends Result
{
    /**
     * @var TopicEntity[]
     */
    public $data = [];
}
