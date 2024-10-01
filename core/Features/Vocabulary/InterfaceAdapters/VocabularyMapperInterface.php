<?php

namespace Core\Features\Vocabulary\InterfaceAdapters;

use Core\Features\Vocabulary\Entities\VocabularyEntity;

interface VocabularyMapperInterface
{
    /**
     * @param mixed $data Data.
     *
     * @return VocabularyEntity|null
     */
    public function mapFromDbToEntity($data);
    /**
     * @param mixed $data Data.
     *
     * @return VocabularyEntity[]
     */
    public function mapFromDbToListEntities($data);
    /**
     * @param mixed $data Data.
     *
     * @return VocabularyEntity|null
     */
    public function mapFromCacheToEntity($data);
    /**
     * @param mixed $data Data.
     *
     * @return VocabularyEntity[]
     */
    public function mapFromCacheToListEntities($data);
}
