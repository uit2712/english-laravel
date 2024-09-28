<?php

namespace Tests\Feature\Topic;

use Core\Constants\ErrorMessage;
use Core\Constants\SuccessMessage;
use Core\Features\Group\Facades\GroupApi;
use Core\Features\Topic\Facades\TopicApi;
use Database\Seeders\GroupSeeder;
use Database\Seeders\TopicSeeder;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class GetTopicByIdUseCaseTest extends TestCase
{
    use DatabaseTruncation;

    public function testReturnsProperResponseStructure(): void
    {
        $response = $this->get('/topics/444');

        $response->assertJsonStructure(['success', 'message', 'data', 'responseCode']);
    }

    public function testReturnsNotFoundResponse(): void
    {
        $response = $this->get('/topics/444');

        $response->assertNotFound()
            ->assertJson([
                'success' => false,
                'message' => sprintf(ErrorMessage::NOT_FOUND_ITEM, 'Topic'),
                'data' => null,
            ]);
    }

    public function testReturnsOkResponse(): void
    {
        $this->seed(GroupSeeder::class);
        $this->seed(TopicSeeder::class);

        $response = $this->get('/topics/1');

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'message' => sprintf(SuccessMessage::FOUND_ITEM, 'Topic'),
            ]);

        TopicApi::resetTable();
        GroupApi::resetTable();
    }

    public function testReturnsProperDataStructure(): void
    {
        $this->seed(GroupSeeder::class);
        $this->seed(TopicSeeder::class);

        $response = $this->get('/topics/1');

        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'groupId',
            ]
        ]);

        $response->assertJson(fn (AssertableJson $json) =>
        $json
            ->has('data')
            ->whereAllType([
                'data.id' => 'integer',
                'data.name' => 'string',
                'data.groupId' => 'integer',
            ])
            ->etc());

        TopicApi::resetTable();
        GroupApi::resetTable();
    }

    public function testReturnsProperDataValue(): void
    {
        $this->seed(GroupSeeder::class);
        $this->seed(TopicSeeder::class);

        $response = $this->get('/topics/1');

        $response->assertJson([
            'success' => true,
            'message' => sprintf(SuccessMessage::FOUND_ITEM, 'Topic'),
        ]);

        $response->assertJsonPath('data.id', 1);
        $response->assertJsonPath('data.name', 'Thú cưng');
        $response->assertJsonPath('data.groupId', 1);

        TopicApi::resetTable();
        GroupApi::resetTable();
    }
}
