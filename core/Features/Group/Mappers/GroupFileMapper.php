<?php

namespace Core\Features\Group\Mappers;

use Core\Features\Group\Entities\GroupEntity;
use Core\Features\Group\InterfaceAdapters\GroupFileMapperInterface;
use Core\Helpers\ArrayHelper;
use Core\Helpers\NumberHelper;
use Core\Helpers\StringHelper;

class GroupFileMapper implements GroupFileMapperInterface
{
    public function mapFromFileToDbRow($data)
    {
        if (null === $data) {
            return null;
        }

        if (
            isset($data->id) === false ||
            NumberHelper::isPositiveInteger(intval($data->id)) === false
        ) {
            return null;
        }

        if (isset($data->name) === false || StringHelper::isHasValue($data->name) === false) {
            return null;
        }

        $result = new GroupEntity();
        $result->id = intval($data->id);
        $result->name = $data->name;

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
