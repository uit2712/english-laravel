<?php

namespace Core\Features\Vocabulary\Repositories;

use Core\Constants\ErrorMessage;
use Core\Constants\HttpResponseCode;
use Core\Constants\SuccessMessage;
use Core\Features\Database\Facades\Database;
use Core\Features\Vocabulary\Constants\VocabularyConstants;
use Core\Features\Vocabulary\Facades\Vocabulary;
use Core\Features\Vocabulary\InterfaceAdapters\VocabularyRepositoryInterface;
use Core\Features\Vocabulary\Models\GetVocabularyResult;
use Core\Helpers\NumberHelper;

class VocabularyRepository implements VocabularyRepositoryInterface
{
    private $tableName = '';
    private $name = 'Vocabulary';

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
            $result->message = sprintf(SuccessMessage::FOUND_ITEM, $this->name);
        } else {
            $result->message = sprintf(ErrorMessage::NOT_FOUND_ITEM, $this->name);
            $result->responseCode = HttpResponseCode::NOT_FOUND;
            $result->data = $data;
        }

        return $result;
    }
}
