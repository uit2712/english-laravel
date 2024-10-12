<?php

namespace Core\Features\Topic\Mappers;

use Core\Features\Topic\Entities\TopicEntity;
use Core\Features\Topic\InterfaceAdapters\TopicMapperInterface;
use Core\Helpers\ArrayHelper;
use Core\Helpers\NumberHelper;
use Core\Helpers\StringHelper;

class TopicMapper implements TopicMapperInterface
{
    public function mapFromDbToEntity($data)
    {
        if (null === $data) {
            return null;
        }

        if (isset($data->id) === false || NumberHelper::isPositiveInteger(intval($data->id)) === false) {
            return null;
        }

        if (isset($data->name) === false || StringHelper::isHasValue($data->name) === false) {
            return null;
        }

        if (isset($data->group_id) === false || NumberHelper::isPositiveInteger(intval($data->group_id)) === false) {
            return null;
        }

        $result = new TopicEntity();
        $result->id = intval($data->id);
        $result->name = $data->name;
        $result->groupId = intval($data->group_id);

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

        if (isset($data->groupId) === false || NumberHelper::isPositiveInteger($data->groupId) === false) {
            return null;
        }

        $result = new TopicEntity();
        $result->id = $data->id;
        $result->name = $data->name;
        $result->groupId = $data->groupId;

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
