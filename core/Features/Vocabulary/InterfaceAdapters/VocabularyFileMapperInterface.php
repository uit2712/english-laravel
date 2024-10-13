<?php

namespace Core\Features\Vocabulary\InterfaceAdapters;

interface VocabularyFileMapperInterface
{
    /**
     * @param mixed $data Data.
     *
     * @return mixed|null
     */
    public function mapFromFileToDbRow($data);
    /**
     * @param mixed $data Data.
     *
     * @return mixed[]
     */
    public function mapFromFileToListDbRows($data);
}
