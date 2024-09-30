<?php

namespace Core\Features\Group\InterfaceAdapters;

use Core\Features\Group\Models\GetGroupResult;
use Core\Features\Group\Models\GetListGroupsResult;
use Core\Models\Result;

interface GroupRepositoryInterface
{
    /**
     * @param int|null $pageIndex Page start from 0.
     * @param int|null $perPage Per page.
     */
    public function getMultiple($pageIndex, $perPage): GetListGroupsResult;
    /**
     * @param int $id Id.
     */
    public function get($id): GetGroupResult;
    public function reset(): Result;
}
