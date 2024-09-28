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

    /**
     * @param string $queryStr Query string.
     */
    public function query($queryStr): mixed;

    /**
     * @param string $tableName Table name.
     */
    public function truncate($tableName): mixed;
}
