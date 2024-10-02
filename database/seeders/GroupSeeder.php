<?php

namespace Database\Seeders;

use Core\Features\Group\Constants\GroupConstants;
use Core\Features\Group\Facades\GroupApi;
use Core\Features\JsonConverter\Facades\JsonConverterApi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tableName = GroupConstants::TABLE_NAME;
        DB::statement("ALTER TABLE $tableName AUTO_INCREMENT=1");

        $getDataResult = GroupApi::readFromCsvFile();
        if ($getDataResult->isHasArrayData()) {
            $data = $getDataResult->data;
            $dataAsArray = JsonConverterApi::convertToArray($data)->data;
            DB::table($tableName)->insert($dataAsArray);
        }
    }
}
