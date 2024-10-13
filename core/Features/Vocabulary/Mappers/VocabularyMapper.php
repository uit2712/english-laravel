<?php

namespace Core\Features\Vocabulary\Mappers;

use Core\Features\Vocabulary\Entities\VocabularyEntity;
use Core\Features\Vocabulary\InterfaceAdapters\VocabularyMapperInterface;
use Core\Helpers\ArrayHelper;
use Core\Helpers\NumberHelper;
use Core\Helpers\StringHelper;

class VocabularyMapper implements VocabularyMapperInterface
{
    public function mapFromDbToEntity($data)
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

        $result = new VocabularyEntity();
        $result->id = $data->id;
        $result->name = $data->name;
        $result->topicId = $data->topic_id;

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

    public function mapFromDbToListEntities($data)
    {
        $result = [];
        if (ArrayHelper::isHasItems($data) === false) {
            return $result;
        }

        foreach ($data as $item) {
            $newItem = $this->mapFromDbToEntity($item);
            if (null !== $newItem) {
                $result[] = $newItem;
            }
        }

        return $result;
    }

    public function mapFromCacheToEntity($data)
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

        if (isset($data->topicId) === false || NumberHelper::isPositiveInteger($data->topicId) === false) {
            return null;
        }

        $result = new VocabularyEntity();
        $result->id = $data->id;
        $result->name = $data->name;
        $result->topicId = $data->topicId;

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

    public function mapFromCacheToListEntities($data)
    {
        $result = [];
        if (ArrayHelper::isHasItems($data) === false) {
            return $result;
        }

        foreach ($data as $item) {
            $newItem = $this->mapFromCacheToEntity($item);
            if (null !== $newItem) {
                $result[] = $newItem;
            }
        }

        return $result;
    }
}
