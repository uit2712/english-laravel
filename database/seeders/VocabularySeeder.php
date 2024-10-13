<?php

namespace Database\Seeders;

use Core\Features\JsonConverter\Facades\JsonConverterApi;
use Core\Features\Vocabulary\Constants\VocabularyConstants;
use Core\Features\Vocabulary\Facades\VocabularyApi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VocabularySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tableName = VocabularyConstants::TABLE_NAME;
        DB::statement("ALTER TABLE $tableName AUTO_INCREMENT=1");

        $getDataResult = VocabularyApi::readFromCsvFile();
        if ($getDataResult->isHasArrayData()) {
            $data = $getDataResult->data;
            $dataAsArray = JsonConverterApi::convertToArray($data)->data;
            DB::table($tableName)->insert($dataAsArray);
        }
    }
}
