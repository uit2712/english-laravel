<?php

namespace Core\Features\Vocabulary\UseCases;

use Core\Features\File\Facades\CsvFileApi;
use Core\Features\FilePath\Facades\FilePathApi;
use Core\Features\Vocabulary\Constants\VocabularyConstants;
use Core\Features\Vocabulary\Facades\Vocabulary;
use Core\Features\Vocabulary\Models\GetListVocabulariesResult;

class ReadListVocabulariesFromCsvFileUseCase
{
    public function invoke()
    {
        $result = new GetListVocabulariesResult();

        $filePath = FilePathApi::getBasePath() . VocabularyConstants::CSV_DATA_RELATIVE_FILE_PATH;
        $getDataFromFileResult = CsvFileApi::read($filePath);
        $result = $result->copyWithoutData($getDataFromFileResult);
        if ($getDataFromFileResult->isHasArrayData() === false) {
            return $result;
        }

        $result->success = true;
        $result->data = Vocabulary::getFileMapper()->mapFromFileToListDbRows($getDataFromFileResult->data);

        return $result;
    }
}
