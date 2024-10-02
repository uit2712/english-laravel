<?php

namespace Core\Features\Group\UseCases;

use Core\Features\File\Facades\CsvFileApi;
use Core\Features\FilePath\Facades\FilePathApi;
use Core\Features\Group\Constants\GroupConstants;
use Core\Features\Group\Facades\Group;
use Core\Features\Group\Models\GetListGroupsResult;

class ReadListGroupsFromCsvFileUseCase
{
    public function invoke()
    {
        $result = new GetListGroupsResult();

        $filePath = FilePathApi::getBasePath() . GroupConstants::CSV_DATA_RELATIVE_FILE_PATH;
        $getDataFromFileResult = CsvFileApi::read($filePath);
        $result = $result->copyWithoutData($getDataFromFileResult);
        if ($getDataFromFileResult->isHasArrayData() === false) {
            return $result;
        }

        $result->success = true;
        $result->data = Group::getMapper()->mapFromDbToListEntities($getDataFromFileResult->data);

        return $result;
    }
}
