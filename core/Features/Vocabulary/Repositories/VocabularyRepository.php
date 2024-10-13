<?php

namespace Core\Features\Vocabulary\Repositories;

use Core\Constants\ErrorMessage;
use Core\Constants\HttpResponseCode;
use Core\Constants\SuccessMessage;
use Core\Features\Database\Facades\Database;
use Core\Features\Vocabulary\Constants\VocabularyConstants;
use Core\Features\Vocabulary\Facades\Vocabulary;
use Core\Features\Vocabulary\InterfaceAdapters\VocabularyRepositoryInterface;
use Core\Features\Vocabulary\Models\GetListVocabulariesResult;
use Core\Features\Vocabulary\Models\GetVocabularyResult;
use Core\Helpers\ArrayHelper;
use Core\Helpers\NumberHelper;
use Core\Models\Result;

class VocabularyRepository implements VocabularyRepositoryInterface
{
    private $tableName = '';

    public function __construct()
    {
        $this->tableName = VocabularyConstants::TABLE_NAME;
    }

    public function isTableExisted(): bool
    {
        return Database::isTableExisted(VocabularyConstants::TABLE_NAME);
    }

    public function get($id): GetVocabularyResult
    {
        $result = new GetVocabularyResult();

        if (NumberHelper::isPositiveInteger($id) === false) {
            $result->message = sprintf(ErrorMessage::INVALID_PARAMETER, 'id');
            return $result;
        }

        $data = Database::selectOne("SELECT id, name, pronunciation, meaning, image, topic_id FROM {$this->tableName} WHERE id=$id",);
        $result->data = Vocabulary::getMapper()->mapFromDbToEntity($data);

        $result->success = null !== $result->data;
        if ($result->success) {
            $result->message = sprintf(SuccessMessage::FOUND_ITEM, VocabularyConstants::NAME);
        } else {
            $result->message = sprintf(ErrorMessage::NOT_FOUND_ITEM, VocabularyConstants::NAME);
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

    public function getByTopicId($topicId): GetListVocabulariesResult
    {
        $result = new GetListVocabulariesResult();
        if (NumberHelper::isPositiveInteger($topicId) === false) {
            $result->message = sprintf(ErrorMessage::INVALID_PARAMETER, 'topicId');
            return $result;
        }

        $data = Database::select("SELECT id, name, pronunciation, meaning, image, topic_id FROM {$this->tableName} WHERE topic_id=$topicId");
        $result->data = Vocabulary::getMapper()->mapFromDbToListEntities($data);

        $result->success = ArrayHelper::isHasItems($result->data);
        if ($result->success) {
            $result->message = sprintf(SuccessMessage::FOUND_LIST_ITEMS, VocabularyConstants::NAME);
        } else {
            $result->message = sprintf(ErrorMessage::NOT_FOUND_ITEM, VocabularyConstants::NAME);
            $result->responseCode = HttpResponseCode::NOT_FOUND;
            $result->data = $data;
        }

        return $result;
    }
}
