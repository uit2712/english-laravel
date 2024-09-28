<?php

namespace Core\Features\Topic\InterfaceAdapters;

use Core\Features\Topic\Models\GetTopicResult;
use Core\Features\Topic\Models\GetListTopicsResult;
use Core\Models\Result;

interface TopicRepositoryInterface
{
    /**
     * @param int $id Id.
     */
    public function get($id): GetTopicResult;
    /**
     * @param int $groupId Group id.
     */
    public function getByGroupId($groupId): GetListTopicsResult;
    public function reset(): Result;
}
