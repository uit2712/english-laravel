<?php

namespace Tests\Feature\Vocabulary;

use Core\Constants\ErrorMessage;
use Core\Constants\SuccessMessage;
use Core\Features\Group\Facades\GroupApi;
use Core\Features\Topic\Facades\TopicApi;
use Core\Features\Vocabulary\Constants\VocabularyConstants;
use Database\Seeders\GroupSeeder;
use Database\Seeders\TopicSeeder;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class GetVocabularyByIdUseCaseTest extends TestCase
{
    use DatabaseTruncation;

    public function testReturnsProperResponseStructure(): void
    {
        $response = $this->get('/vocabularies/444');

        $response->assertJsonStructure(['success', 'message', 'data', 'responseCode']);
    }

    public function testReturnsNotFoundResponse(): void
    {
        $response = $this->get('/vocabularies/444');

        $response->assertNotFound()
            ->assertJson([
                'success' => false,
                'message' => sprintf(ErrorMessage::NOT_FOUND_ITEM, VocabularyConstants::NAME),
                'data' => null,
            ]);
    }

    public function testReturnsOkResponse(): void
    {
        $this->seed(GroupSeeder::class);
        $this->seed(TopicSeeder::class);

        $response = $this->get('/vocabularies/1');

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'message' => sprintf(SuccessMessage::FOUND_ITEM, VocabularyConstants::NAME),
            ]);

        TopicApi::resetTable();
        GroupApi::resetTable();
    }

    public function testReturnsProperDataStructure(): void
    {
        $this->seed(GroupSeeder::class);
        $this->seed(TopicSeeder::class);

        $response = $this->get('/vocabularies/1');

        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'pronunciation',
                'meaning',
                'image',
                'topicId',
            ]
        ]);

        $response->assertJson(fn (AssertableJson $json) =>
        $json
            ->has('data')
            ->whereAllType([
                'data.id' => 'integer',
                'data.name' => 'string',
                'data.pronunciation' => 'string',
                'data.meaning' => 'string',
                'data.image' => 'string',
                'data.topicId' => 'integer',
            ])
            ->etc());

        TopicApi::resetTable();
        GroupApi::resetTable();
    }

    public function testReturnsProperDataValue(): void
    {
        $this->seed(GroupSeeder::class);
        $this->seed(TopicSeeder::class);

        $response = $this->get('/vocabularies/1');

        $response->assertJson([
            'success' => true,
            'message' => sprintf(SuccessMessage::FOUND_ITEM, VocabularyConstants::NAME),
        ]);

        $response->assertJsonPath('data.id', 1);
        $response->assertJsonPath('data.name', 'cat');
        $response->assertJsonPath('data.pronunciation', '/kæt/');
        $response->assertJsonPath('data.meaning', 'mèo');
        $response->assertJsonPath('data.image', '');
        $response->assertJsonPath('data.topicId', 1);

        TopicApi::resetTable();
        GroupApi::resetTable();
    }
}
