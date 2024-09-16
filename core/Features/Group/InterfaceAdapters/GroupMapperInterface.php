<?php

namespace Core\Features\Group\InterfaceAdapters;

use Core\Features\Group\Entities\GroupEntity;

interface GroupMapperInterface
{
    /**
     * @param mixed $data Data.
     *
     * @return GroupEntity|null
     */
    public function mapFromDbToEntity($data);
    /**
     * @param mixed $data Data.
     *
     * @return GroupEntity[]
     */
    public function mapFromDbToListEntities($data);
    /**
     * @param mixed $data Data.
     *
     * @return GroupEntity|null
     */
    public function mapFromCacheToEntity($data);
    /**
     * @param mixed $data Data.
     *
     * @return GroupEntity[]
     */
    public function mapFromCacheToListEntities($data);
}
