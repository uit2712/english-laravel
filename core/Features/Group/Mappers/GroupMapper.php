<?php

namespace Core\Features\Group\Mappers;

use Core\Features\Group\Entities\GroupEntity;
use Core\Features\Group\InterfaceAdapters\GroupMapperInterface;
use Core\Helpers\ArrayHelper;
use Core\Helpers\NumberHelper;
use Core\Helpers\StringHelper;

class GroupMapper implements GroupMapperInterface
{
    public function mapFromDbToEntity($data)
    {
        if (null === $data) {
            return null;
        }


        if (isset($data->id) && NumberHelper::isPositiveInteger($data->id)) {
            return null;
        }

        if (isset($data->name) && StringHelper::isHasValue($data->name)) {
            return null;
        }

        $result = new GroupEntity();
        $result->id = $data->id;
        $result->name = $data->name;

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
}
