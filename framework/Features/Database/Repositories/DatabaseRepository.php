<?php

namespace Framework\Features\Database\Repositories;

use Core\Features\Database\InterfaceAdapters\DatabaseRepositoryInterface;
use Core\Helpers\StringHelper;
use Illuminate\Support\Facades\DB;

class DatabaseRepository implements DatabaseRepositoryInterface
{
    public function select($queryStr): array
    {
        if (StringHelper::isHasValue($queryStr) === false) {
            return [];
        }

        return DB::select($queryStr);
    }

    public function selectOne($queryStr): mixed
    {
        if (StringHelper::isHasValue($queryStr) === false) {
            return [];
        }

        return DB::selectOne($queryStr);
    }

    public function query($queryStr): mixed
    {
        if (StringHelper::isHasValue($queryStr) === false) {
            return null;
        }

        return DB::query($queryStr);
    }

    public function truncate($tableName): mixed
    {
        if (StringHelper::isHasValue($tableName) === false) {
            return null;
        }

        return DB::table($tableName)->truncate();
    }
}
