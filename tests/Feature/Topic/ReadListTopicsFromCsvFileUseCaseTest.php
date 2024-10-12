<?php

namespace Tests\Feature\Topic;

use Core\Constants\SuccessMessage;
use Core\Features\FilePath\Facades\FilePathApi;
use Core\Features\Topic\Constants\TopicConstants;
use Core\Features\Topic\Facades\Topic;
use Core\Features\Topic\Facades\TopicApi;
use Core\Features\Topic\Models\GetListTopicsResult;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ReadListTopicsFromCsvFileUseCaseTest extends TestCase
{
    public function testReturnsProperResponseStructure(): void
    {
        $response = $this->get('/topics/readFromCsvFile');

        $response->assertJsonStructure(['success', 'message', 'data', 'responseCode']);
    }

    public function testReturnsFileExists(): void
    {
        $filePath = FilePathApi::getBasePath() . TopicConstants::CSV_DATA_RELATIVE_FILE_PATH;
        $expectedResult = new GetListTopicsResult();
        $expectedResult->success = true;
        $expectedResult->message = sprintf(SuccessMessage::FILE_EXISTS, $filePath);

        $actualResult = TopicApi::readFromCsvFile();

        $this->assertTrue($actualResult->success);
        $this->assertEquals($expectedResult->success, $actualResult->success);
        $this->assertEquals($expectedResult->message, $actualResult->message);
    }

    public function testReturnsProperDataStructure(): void
    {
        $response = $this->get('/topics/readFromCsvFile');

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'group_id',
                ]
            ]
        ]);

        $response->assertJson(fn (AssertableJson $json) =>
        $json
            ->has('data')
            ->whereAllType([
                'data' => 'array',
                'data.0.id' => 'integer',
                'data.0.name' => 'string',
                'data.0.group_id' => 'integer',
            ])
            ->etc());
    }

    public function testReturnsProperDataValue(): void
    {
        $filePath = FilePathApi::getBasePath() . TopicConstants::CSV_DATA_RELATIVE_FILE_PATH;
        $expectedResult = new GetListTopicsResult();
        $expectedResult->success = true;
        $expectedResult->message = sprintf(SuccessMessage::FILE_EXISTS, $filePath);
        $expectedResult->data[] = Topic::getMapper()->mapFromDbToEntity(
            json_decode(json_encode(['id' => 1, 'name' => 'Thú cưng', 'group_id' => 1]))
        );
        $expectedResult->data[] = Topic::getMapper()->mapFromDbToEntity(
            json_decode(json_encode(['id' => 2, 'name' => 'Các loài chim', 'group_id' => 1]))
        );

        $response = $this->get('/topics/readFromCsvFile');

        $response->assertJsonPath('data.0.id', 1);
        $response->assertJsonPath('data.0.name', 'Thú cưng');
        $response->assertJsonPath('data.0.group_id', 1);
    }
}
