<?php

namespace Core\Features\Group\Repositories;

use Core\Constants\ErrorMessage;
use Core\Constants\HttpResponseCode;
use Core\Constants\SuccessMessage;
use Core\Features\Database\Facades\Database;
use Core\Features\Group\Constants\GroupConstants;
use Core\Features\Group\Facades\Group;
use Core\Features\Group\InterfaceAdapters\GroupRepositoryInterface;
use Core\Features\Group\Models\GetGroupResult;
use Core\Features\Group\Models\GetListGroupsResult;
use Core\Helpers\ArrayHelper;
use Core\Helpers\NumberHelper;
use Core\Models\Result;

class GroupRepository implements GroupRepositoryInterface
{
    private $tableName = '';
    private $name = 'Group';

    public function __construct()
    {
        $this->tableName = GroupConstants::TABLE_NAME;
    }

    public function getAll(): GetListGroupsResult
    {
        $result = new GetListGroupsResult();

        $data = Database::select("SELECT id, name FROM {$this->tableName}");
        $result->data = Group::getMapper()->mapFromDbToListEntities($data);

        $result->success = ArrayHelper::isHasItems($result->data);
        if ($result->success) {
            $result->message = sprintf(SuccessMessage::FOUND_LIST_ITEMS, $this->name);
        } else {
            $result->message = sprintf(ErrorMessage::NOT_FOUND_ITEM, $this->name);
            $result->responseCode = HttpResponseCode::NOT_FOUND;
        }

        return $result;
    }

    public function get($id): GetGroupResult
    {
        $result = new GetGroupResult();

        if (NumberHelper::isPositiveInteger($id) === false) {
            $result->message = sprintf(ErrorMessage::INVALID_PARAMETER, 'id');
            return $result;
        }

        $data = Database::selectOne("SELECT id, name FROM {$this->tableName} WHERE id=$id",);
        $result->data = Group::getMapper()->mapFromDbToEntity($data);

        $result->success = null !== $result->data;
        if ($result->success) {
            $result->message = sprintf(SuccessMessage::FOUND_ITEM, $this->name);
        } else {
            $result->message = sprintf(ErrorMessage::NOT_FOUND_ITEM, $this->name);
            $result->responseCode = HttpResponseCode::NOT_FOUND;
        }

        return $result;
    }

    public function reset(): Result
    {
        $result = new Result();
        Database::truncate($this->tableName);

        return $result;
    }
}
