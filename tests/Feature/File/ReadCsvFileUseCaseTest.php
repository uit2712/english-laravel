<?php

namespace Tests\Feature\File;

use Core\Constants\ErrorMessage;
use Core\Constants\HttpResponseCode;
use Core\Constants\SuccessMessage;
use Core\Features\File\Facades\CsvFileApi;
use Core\Features\FilePath\Facades\FilePathApi;
use Core\Features\Group\Constants\GroupConstants;
use Core\Models\Result;
use Tests\TestCase;

class ReadCsvFileUseCaseTest extends TestCase
{
    public function testReturnsInvalidFilePath(): void
    {
        $filePath = null;

        $actualResult = CsvFileApi::read($filePath);

        $expectedResult = new Result();
        $expectedResult->message = sprintf(ErrorMessage::INVALID_PARAMETER, 'filePath');
        $expectedResult->responseCode = HttpResponseCode::BAD_REQUEST;

        $this->assertFalse($actualResult->success);
        $this->assertEquals($expectedResult->success, $actualResult->success);
        $this->assertEquals($expectedResult->message, $actualResult->message);
        $this->assertEquals($expectedResult->responseCode, $actualResult->responseCode);
    }

    public function testReturnsFileNotExists(): void
    {
        $filePath = '/test/testabcdefdsafdafds.txt';

        $actualResult = CsvFileApi::read($filePath);

        $expectedResult = new Result();
        $expectedResult->message = sprintf(ErrorMessage::FILE_NOT_FOUND, $filePath);
        $expectedResult->responseCode = HttpResponseCode::NOT_FOUND;

        $this->assertFalse($actualResult->success);
        $this->assertEquals($expectedResult->success, $actualResult->success);
        $this->assertEquals($expectedResult->message, $actualResult->message);
        $this->assertEquals($expectedResult->responseCode, $actualResult->responseCode);
    }

    public function testReturnsFileExists(): void
    {
        $filePath = FilePathApi::getBasePath() . GroupConstants::CSV_DATA_RELATIVE_FILE_PATH;

        $actualResult = CsvFileApi::read($filePath);

        $expectedResult = new Result();
        $expectedResult->success = true;
        $expectedResult->message = sprintf(SuccessMessage::FILE_EXISTS, $filePath);

        $this->assertTrue($actualResult->success);
        $this->assertEquals($expectedResult->success, $actualResult->success);
        $this->assertEquals($expectedResult->message, $actualResult->message);
    }

    public function testReturnsProperDataStructure(): void
    {
        $filePath = FilePathApi::getBasePath() . GroupConstants::CSV_DATA_RELATIVE_FILE_PATH;

        $actualResult = CsvFileApi::read($filePath);

        $expectedResult = new Result();
        $expectedResult->success = true;
        $expectedResult->message = sprintf(SuccessMessage::FILE_EXISTS, $filePath);

        $this->assertTrue($actualResult->success);
        $this->assertEquals($expectedResult->success, $actualResult->success);
        $this->assertEquals($expectedResult->message, $actualResult->message);
        $this->assertIsArray($actualResult->data);
        $this->assertEquals(2, count($actualResult->data));
    }
}
