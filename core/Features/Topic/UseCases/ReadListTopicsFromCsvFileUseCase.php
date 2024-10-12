<?php

namespace Core\Features\Topic\UseCases;

use Core\Features\File\Facades\CsvFileApi;
use Core\Features\FilePath\Facades\FilePathApi;
use Core\Features\Topic\Constants\TopicConstants;
use Core\Features\Topic\Facades\Topic;
use Core\Features\Topic\Models\GetListTopicsResult;

class ReadListTopicsFromCsvFileUseCase
{
    public function invoke()
    {
        $result = new GetListTopicsResult();

        $filePath = FilePathApi::getBasePath() . TopicConstants::CSV_DATA_RELATIVE_FILE_PATH;
        $getDataFromFileResult = CsvFileApi::read($filePath);
        $result = $result->copyWithoutData($getDataFromFileResult);
        if ($getDataFromFileResult->isHasArrayData() === false) {
            return $result;
        }

        $result->success = true;
        $result->data = Topic::getMapper()->mapFromDbToListEntities($getDataFromFileResult->data);

        return $result;
    }
}
