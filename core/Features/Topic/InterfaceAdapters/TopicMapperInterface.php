<?php

namespace Core\Features\Topic\InterfaceAdapters;

use Core\Features\Topic\Entities\TopicEntity;

interface TopicMapperInterface
{
    /**
     * @param mixed $data Data.
     *
     * @return TopicEntity|null
     */
    public function mapFromDbToEntity($data);
    /**
     * @param mixed $data Data.
     *
     * @return TopicEntity[]
     */
    public function mapFromDbToListEntities($data);
    /**
     * @param mixed $data Data.
     *
     * @return TopicEntity|null
     */
    public function mapFromCacheToEntity($data);
    /**
     * @param mixed $data Data.
     *
     * @return TopicEntity[]
     */
    public function mapFromCacheToListEntities($data);
}
