<?php

namespace Tests\Feature\Vocabulary;

use Core\Constants\SuccessMessage;
use Core\Features\FilePath\Facades\FilePathApi;
use Core\Features\Vocabulary\Constants\VocabularyConstants;
use Core\Features\Vocabulary\Facades\Vocabulary;
use Core\Features\Vocabulary\Facades\VocabularyApi;
use Core\Features\Vocabulary\Models\GetListVocabulariesResult;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ReadListVocabulariesFromCsvFileUseCaseTest extends TestCase
{
    public function testReturnsProperResponseStructure(): void
    {
        $response = $this->get('/vocabularies/readFromCsvFile');

        $response->assertJsonStructure(['success', 'message', 'data', 'responseCode']);
    }

    public function testReturnsFileExists(): void
    {
        $filePath = FilePathApi::getBasePath() . VocabularyConstants::CSV_DATA_RELATIVE_FILE_PATH;
        $expectedResult = new GetListVocabulariesResult();
        $expectedResult->success = true;
        $expectedResult->message = sprintf(SuccessMessage::FILE_EXISTS, $filePath);

        $actualResult = VocabularyApi::readFromCsvFile();

        $this->assertTrue($actualResult->success);
        $this->assertEquals($expectedResult->success, $actualResult->success);
        $this->assertEquals($expectedResult->message, $actualResult->message);
    }

    public function testReturnsProperDataStructure(): void
    {
        $response = $this->get('/vocabularies/readFromCsvFile');

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'pronunciation',
                    'meaning',
                    'image',
                    'topic_id',
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
                'data.0.pronunciation' => 'string',
                'data.0.meaning' => 'string',
                'data.0.image' => 'string',
                'data.0.topic_id' => 'integer',
            ])
            ->etc());
    }

    public function testReturnsProperDataValue(): void
    {
        $filePath = FilePathApi::getBasePath() . VocabularyConstants::CSV_DATA_RELATIVE_FILE_PATH;
        $expectedResult = new GetListVocabulariesResult();
        $expectedResult->success = true;
        $expectedResult->message = sprintf(SuccessMessage::FILE_EXISTS, $filePath);
        $expectedResult->data[] = Vocabulary::getMapper()->mapFromDbToEntity(
            json_decode(json_encode([
                'id' => 1,
                'name' => 'cat',
                'pronunciation' => '/kæt/',
                'meaning' => 'mèo',
                'image' => '',
                'topic_id' => 1,
            ]))
        );
        $expectedResult->data[] = Vocabulary::getMapper()->mapFromDbToEntity(
            json_decode(json_encode([
                'id' => 2,
                'name' => 'kitten',
                'pronunciation' => '/ˈkɪt.ən/',
                'meaning' => 'mèo con',
                'image' => '',
                'topic_id' => 1,
            ]))
        );

        $response = $this->get('/vocabularies/readFromCsvFile');

        $response->assertJsonPath('data.0.id', 1);
        $response->assertJsonPath('data.0.name', 'cat');
        $response->assertJsonPath('data.0.pronunciation', '/kæt/');
        $response->assertJsonPath('data.0.meaning', 'mèo');
        $response->assertJsonPath('data.0.image', '');
        $response->assertJsonPath('data.0.topic_id', 1);
    }
}
