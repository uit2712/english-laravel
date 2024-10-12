<?php

namespace Core\Features\Topic\InterfaceAdapters;

interface TopicFileMapperInterface
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
