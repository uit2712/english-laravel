<?php

namespace Core\Features\Database\InterfaceAdapters;

interface DatabaseRepositoryInterface
{
    /**
     * @param string $queryStr Query string.
     */
    public function select($queryStr): array;

    /**
     * @param string $queryStr Query string.
     */
    public function selectOne($queryStr): mixed;
}
