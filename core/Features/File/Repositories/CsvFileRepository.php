<?php

namespace Core\Features\File\Repositories;

use Core\Constants\ErrorMessage;
use Core\Constants\HttpResponseCode;
use Core\Constants\SuccessMessage;
use Core\Features\File\InterfaceAdapters\CsvFileRepositoryInterface;
use Core\Helpers\ArrayHelper;
use Core\Helpers\StringHelper;
use Core\Models\Result;
use stdClass;

class CsvFileRepository implements CsvFileRepositoryInterface
{
    public function read($filePath): Result
    {
        $result = new Result();
        $result->data = [];
        if (StringHelper::isHasValue($filePath) === false) {
            $result->message = sprintf(ErrorMessage::INVALID_PARAMETER, 'filePath');
            $result->responseCode = HttpResponseCode::BAD_REQUEST;
            return $result;
        }

        if (file_exists($filePath) === false) {
            $result->message = sprintf(ErrorMessage::FILE_NOT_FOUND, $filePath);
            $result->responseCode = HttpResponseCode::NOT_FOUND;
            return $result;
        }

        $row = 1;
        $headers = [];
        ini_set('auto_detect_line_endings', true);
        $handle = fopen($filePath, 'r');
        while (($data = fgetcsv($handle) ) !== false) {
            if (1 === $row) {
                $row++;
                if (ArrayHelper::isHasItems($data)) {
                    $headers = $data;
                }
                continue;
            }

            if (ArrayHelper::isHasItems($data)) {
                $newItem = new stdClass();
                foreach ($data as $index => $item) {
                    if ($index < count($headers)) {
                        $columnName = $headers[$index];
                        $newItem->$columnName = $item;
                    }
                }
                $result->data[] = $newItem;
                $row++;
            }
        }
        ini_set('auto_detect_line_endings', false);

        $result->success = ArrayHelper::isHasItems($result->data);
        $result->message = sprintf(SuccessMessage::FILE_EXISTS, $filePath);

        return $result;
    }
}
