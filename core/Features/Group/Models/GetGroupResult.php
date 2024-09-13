<?php

namespace Core\Features\Group\Models;

use Core\Features\Group\Entities\GroupEntity;
use Core\Models\Result;

class GetGroupResult extends Result
{
    /**
     * @var GroupEntity
     */
    public $data = null;
}
