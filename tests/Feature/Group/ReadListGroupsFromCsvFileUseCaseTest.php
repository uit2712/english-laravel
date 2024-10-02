<?php

namespace Tests\Feature\Group;

use Core\Constants\SuccessMessage;
use Core\Features\FilePath\Facades\FilePathApi;
use Core\Features\Group\Constants\GroupConstants;
use Core\Features\Group\Facades\Group;
use Core\Features\Group\Facades\GroupApi;
use Core\Features\Group\Models\GetListGroupsResult;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ReadListGroupsFromCsvFileUseCaseTest extends TestCase
{
    public function testReturnsProperResponseStructure(): void
    {
        $response = $this->get('/groups/readFromCsvFile');

        $response->assertJsonStructure(['success', 'message', 'data', 'responseCode']);
    }

    public function testReturnsFileExists(): void
    {
        $filePath = FilePathApi::getBasePath() . GroupConstants::CSV_DATA_RELATIVE_FILE_PATH;
        $expectedResult = new GetListGroupsResult();
        $expectedResult->success = true;
        $expectedResult->message = sprintf(SuccessMessage::FILE_EXISTS, $filePath);

        $actualResult = GroupApi::readFromCsvFile();

        $this->assertTrue($actualResult->success);
        $this->assertEquals($expectedResult->success, $actualResult->success);
        $this->assertEquals($expectedResult->message, $actualResult->message);
    }

    public function testReturnsProperDataStructure(): void
    {
        $response = $this->get('/groups/readFromCsvFile');

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
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
            ])
            ->etc());
    }

    public function testReturnsProperDataValue(): void
    {
        $filePath = FilePathApi::getBasePath() . GroupConstants::CSV_DATA_RELATIVE_FILE_PATH;
        $expectedResult = new GetListGroupsResult();
        $expectedResult->success = true;
        $expectedResult->message = sprintf(SuccessMessage::FILE_EXISTS, $filePath);
        $expectedResult->data[] = Group::getMapper()->mapFromDbToEntity(
            json_decode(json_encode(['id' => 1, 'name' => 'Động vật']))
        );
        $expectedResult->data[] = Group::getMapper()->mapFromDbToEntity(
            json_decode(json_encode(['id' => 2, 'name' => 'Nghề nghiệp']))
        );

        $response = $this->get('/groups/readFromCsvFile');

        $response->assertJsonCount(2, 'data');

        $response->assertJsonPath('data.0.id', 1);
        $response->assertJsonPath('data.0.name', 'Động vật');
    }
}
