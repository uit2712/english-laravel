<?php

namespace Core\Features\Topic\Repositories;

use Core\Constants\ErrorMessage;
use Core\Constants\HttpResponseCode;
use Core\Constants\SuccessMessage;
use Core\Features\Database\Facades\Database;
use Core\Features\Topic\Constants\TopicConstants;
use Core\Features\Topic\Facades\Topic;
use Core\Features\Topic\InterfaceAdapters\TopicRepositoryInterface;
use Core\Features\Topic\Models\GetTopicResult;
use Core\Features\Topic\Models\GetListTopicsResult;
use Core\Helpers\ArrayHelper;
use Core\Helpers\NumberHelper;
use Core\Models\Result;

class TopicRepository implements TopicRepositoryInterface
{
    private $tableName = '';
    private $name = 'Topic';

    public function __construct()
    {
        $this->tableName = TopicConstants::TABLE_NAME;
    }

    public function get($id): GetTopicResult
    {
        $result = new GetTopicResult();

        if (NumberHelper::isPositiveInteger($id) === false) {
            $result->message = sprintf(ErrorMessage::INVALID_PARAMETER, 'id');
            return $result;
        }

        $data = Database::selectOne("SELECT id, name, group_id FROM {$this->tableName} WHERE id=$id",);
        $result->data = Topic::getMapper()->mapFromDbToEntity($data);

        $result->success = null !== $result->data;
        if ($result->success) {
            $result->message = sprintf(SuccessMessage::FOUND_ITEM, $this->name);
        } else {
            $result->message = sprintf(ErrorMessage::NOT_FOUND_ITEM, $this->name);
            $result->responseCode = HttpResponseCode::NOT_FOUND;
            $result->data = $data;
        }

        return $result;
    }

    public function reset(): Result
    {
        $result = new Result();
        Database::truncate($this->tableName);

        return $result;
    }

    public function getByGroupId($groupId): GetListTopicsResult
    {
        $result = new GetListTopicsResult();
        if (NumberHelper::isPositiveInteger($groupId) === false) {
            $result->message = sprintf(ErrorMessage::INVALID_PARAMETER, 'groupId');
            return $result;
        }

        $data = Database::select("SELECT id, name, group_id FROM {$this->tableName} WHERE group_id=$groupId");
        $result->data = Topic::getMapper()->mapFromDbToListEntities($data);

        $result->success = ArrayHelper::isHasItems($result->data);
        if ($result->success) {
            $result->message = sprintf(SuccessMessage::FOUND_LIST_ITEMS, $this->name);
        } else {
            $result->message = sprintf(ErrorMessage::NOT_FOUND_ITEM, $this->name);
            $result->responseCode = HttpResponseCode::NOT_FOUND;
            $result->data = $data;
        }

        return $result;
    }
}
