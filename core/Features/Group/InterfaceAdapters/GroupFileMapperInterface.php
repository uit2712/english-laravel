<?php

namespace Core\Features\Group\InterfaceAdapters;

interface GroupFileMapperInterface
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
