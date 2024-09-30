<?php

namespace Core\Features\Group\InterfaceAdapters;

use Core\Features\Group\Models\GetGroupResult;
use Core\Features\Group\Models\GetListGroupsResult;

interface CachedGroupRepositoryInterface
{
    /**
     * @param int $id Id.
     */
    public function get($id): GetGroupResult;
}
