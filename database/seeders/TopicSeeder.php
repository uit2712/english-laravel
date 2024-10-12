<?php

namespace Database\Seeders;

use Core\Features\JsonConverter\Facades\JsonConverterApi;
use Core\Features\Topic\Constants\TopicConstants;
use Core\Features\Topic\Facades\TopicApi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tableName = TopicConstants::TABLE_NAME;

        DB::statement("ALTER TABLE $tableName AUTO_INCREMENT=1");
        $getDataResult = TopicApi::readFromCsvFile();
        if ($getDataResult->isHasArrayData()) {
            $data = $getDataResult->data;
            $dataAsArray = JsonConverterApi::convertToArray($data)->data;
            DB::table($tableName)->insert($dataAsArray);
        }
    }
}
