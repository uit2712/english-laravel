<?php

namespace Tests\Feature\Group;

use Core\Constants\ErrorMessage;
use Core\Constants\SuccessMessage;
use Core\Features\Cache\Facades\CustomCacheApi;
use Core\Features\Group\Facades\GroupApi;
use Core\Features\Topic\Constants\TopicConstants;
use Core\Features\Topic\Facades\TopicApi;
use Core\Features\Vocabulary\Constants\VocabularyConstants;
use Core\Features\Vocabulary\Facades\VocabularyApi;
use Database\Seeders\GroupSeeder;
use Database\Seeders\TopicSeeder;
use Database\Seeders\VocabularySeeder;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class GetListVocabulariesByTopicIdUseCaseTest extends TestCase
{
    use DatabaseTruncation;

    public function testReturnsProperResponseStructure(): void
    {
        $response = $this->get('/topics/999999/vocabularies');

        $response->assertJsonStructure(['success', 'message', 'data', 'responseCode']);
    }

    public function testReturnsNotFoundTopicResponse(): void
    {
        $response = $this->get('/topics/999999/vocabularies');

        $response->assertNotFound()
            ->assertJson([
                'success' => false,
                'message' => sprintf(ErrorMessage::NOT_FOUND_ITEM, TopicConstants::NAME),
                'data' => [],
            ]);
    }

    public function testReturnsNotFoundAnyVocabulariesResponse(): void
    {
        CustomCacheApi::flushAll();
        $this->seed(GroupSeeder::class);
        $this->seed(TopicSeeder::class);

        $response = $this->get('/topics/1/vocabularies');

        $response->assertNotFound()
            ->assertJson([
                'success' => false,
                'message' => sprintf(ErrorMessage::NOT_FOUND_ITEM, VocabularyConstants::NAME),
                'data' => [],
            ]);

        TopicApi::resetTable();
        GroupApi::resetTable();
    }

    public function testReturnsOkResponse(): void
    {
        $this->seed(GroupSeeder::class);
        $this->seed(TopicSeeder::class);
        $this->seed(VocabularySeeder::class);

        $response = $this->get('/topics/1/vocabularies');

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'message' => sprintf(SuccessMessage::FOUND_LIST_ITEMS, VocabularyConstants::NAME),
            ]);

        VocabularyApi::resetTable();
        TopicApi::resetTable();
        GroupApi::resetTable();
    }

    public function testReturnsProperDataStructure(): void
    {
        $this->seed(GroupSeeder::class);
        $this->seed(TopicSeeder::class);
        $this->seed(VocabularySeeder::class);

        $response = $this->get('/topics/1/vocabularies');

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'pronunciation',
                    'meaning',
                    'image',
                    'topicId',
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
                'data.0.topicId' => 'integer',
            ])
            ->etc());

        VocabularyApi::resetTable();
        TopicApi::resetTable();
        GroupApi::resetTable();
    }

    public function testReturnsProperDataValue(): void
    {
        $this->seed(GroupSeeder::class);
        $this->seed(TopicSeeder::class);
        $this->seed(VocabularySeeder::class);

        $response = $this->get('/topics/1/vocabularies');

        $response->assertJsonPath('data.0.id', 1);
        $response->assertJsonPath('data.0.name', 'cat');
        $response->assertJsonPath('data.0.pronunciation', '/kæt/');
        $response->assertJsonPath('data.0.meaning', 'mèo');
        $response->assertJsonPath('data.0.image', '');
        $response->assertJsonPath('data.0.topicId', 1);

        VocabularyApi::resetTable();
        TopicApi::resetTable();
        GroupApi::resetTable();
    }
}
