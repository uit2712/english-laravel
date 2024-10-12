<?php

namespace Core\Features\Topic\Mappers;

use Core\Features\Topic\InterfaceAdapters\TopicFileMapperInterface;
use Core\Helpers\ArrayHelper;
use Core\Helpers\NumberHelper;
use Core\Helpers\StringHelper;
use stdClass;

class TopicFileMapper implements TopicFileMapperInterface
{
    public function mapFromFileToDbRow($data)
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

        $result = new stdClass();
        $result->id = intval($data->id);
        $result->name = $data->name;
        $result->group_id = intval($data->group_id);

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
