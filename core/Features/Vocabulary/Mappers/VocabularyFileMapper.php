<?php

namespace Core\Features\Vocabulary\Mappers;

use Core\Features\Vocabulary\InterfaceAdapters\VocabularyFileMapperInterface;
use Core\Helpers\ArrayHelper;
use Core\Helpers\NumberHelper;
use Core\Helpers\StringHelper;
use stdClass;

class VocabularyFileMapper implements VocabularyFileMapperInterface
{
    public function mapFromFileToDbRow($data)
    {
        if (null === $data) {
            return null;
        }

        if (isset($data->id) === false || NumberHelper::isPositiveInteger($data->id) === false) {
            return null;
        }

        if (isset($data->name) === false || StringHelper::isHasValue($data->name) === false) {
            return null;
        }

        if (isset($data->topic_id) === false || NumberHelper::isPositiveInteger($data->topic_id) === false) {
            return null;
        }

        $result = new stdClass();
        $result->id = $data->id;
        $result->name = $data->name;
        $result->topic_id = $data->topic_id;

        if (StringHelper::isHasValue($data->pronunciation)) {
            $result->pronunciation = $data->pronunciation;
        }

        if (StringHelper::isHasValue($data->meaning)) {
            $result->meaning = $data->meaning;
        }

        if (StringHelper::isHasValue($data->image)) {
            $result->image = $data->image;
        }

        return $result;
    }

    public function mapFromFileToListDbRows($data)
    {
        $result = [];
        if (ArrayHelper::isHasItems($data) === false) {
            return $result;
        }

        foreach ($data as $item) {
            $newItem = $this->mapFromFileToDbRow($item);
            if (null !== $newItem) {
                $result[] = $newItem;
            }
        }

        return $result;
    }
}
