<?php

namespace Core\Features\Group\InterfaceAdapters;

use Core\Features\Group\Models\GetGroupResult;
use Core\Features\Group\Models\GetListGroupsResult;

interface CachedGroupRepositoryInterface
{
    public function getAll(): GetListGroupsResult;
    /**
     * @param int $id Id.
     */
    public function get($id): GetGroupResult;
}
