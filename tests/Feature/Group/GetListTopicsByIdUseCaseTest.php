<?php

namespace Tests\Feature\Group;

use Core\Constants\ErrorMessage;
use Core\Constants\SuccessMessage;
use Core\Features\Group\Facades\GroupApi;
use Core\Features\Topic\Facades\TopicApi;
use Database\Seeders\GroupSeeder;
use Database\Seeders\TopicSeeder;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class GetListTopicsByIdUseCaseTest extends TestCase
{
    use DatabaseTruncation;

    public function testReturnsProperResponseStructure(): void
    {
        $response = $this->get('/groups/444/topics');

        $response->assertJsonStructure(['success', 'message', 'data', 'responseCode']);
    }

    public function testReturnsNotFoundGroupResponse(): void
    {
        $response = $this->get('/groups/444/topics');

        $response->assertNotFound()
            ->assertJson([
                'success' => false,
                'message' => sprintf(ErrorMessage::NOT_FOUND_ITEM, 'Group'),
                'data' => [],
            ]);
    }

    public function testReturnsNotFoundAnyTopicsResponse(): void
    {
        $this->seed(GroupSeeder::class);

        $response = $this->get('/groups/2/topics');

        $response->assertNotFound()
            ->assertJson([
                'success' => false,
                'message' => sprintf(ErrorMessage::NOT_FOUND_ITEM, 'Topic'),
                'data' => [],
            ]);

        GroupApi::resetTable();
    }

    public function testReturnsOkResponse(): void
    {
        $this->seed(GroupSeeder::class);
        $this->seed(TopicSeeder::class);

        $response = $this->get('/groups/1/topics');

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'message' => sprintf(SuccessMessage::FOUND_LIST_ITEMS, 'Topic'),
            ]);

        TopicApi::resetTable();
        GroupApi::resetTable();
    }

    public function testReturnsProperDataStructure(): void
    {
        $this->seed(GroupSeeder::class);
        $this->seed(TopicSeeder::class);

        $response = $this->get('/groups/1/topics');

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'groupId',
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
                'data.0.groupId' => 'integer',
            ])
            ->etc());

        TopicApi::resetTable();
        GroupApi::resetTable();
    }

    public function testReturnsProperDataValue(): void
    {
        $this->seed(GroupSeeder::class);
        $this->seed(TopicSeeder::class);

        $response = $this->get('/groups/1/topics');

        $response->assertJsonCount(8, 'data');

        $response->assertJsonPath('data.0.id', 1);
        $response->assertJsonPath('data.0.name', 'Thú cưng');
        $response->assertJsonPath('data.0.groupId', 1);

        TopicApi::resetTable();
        GroupApi::resetTable();
    }
}
