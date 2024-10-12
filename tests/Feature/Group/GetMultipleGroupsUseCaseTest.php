<?php

namespace Tests\Feature\Group;

use Core\Constants\ErrorMessage;
use Core\Constants\SuccessMessage;
use Core\Features\Group\Facades\GroupApi;
use Core\Features\Topic\Facades\TopicApi;
use Database\Seeders\GroupSeeder;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class GetMultipleGroupsUseCaseTest extends TestCase
{
    use DatabaseTruncation;

    public function testReturnsProperResponseStructure(): void
    {
        $response = $this->get('/groups?page=0&perPage=1');

        $response->assertJsonStructure(['success', 'message', 'data', 'responseCode']);
    }

    public function testReturnsInvalidPageIndexResponse(): void
    {
        $response = $this->get('/groups?page=-1&perPage=1');

        $response->assertBadRequest()
            ->assertJson([
                'success' => false,
                'message' => sprintf(ErrorMessage::INVALID_PARAMETER . ': pageIndex must >= 0', 'pageIndex'),
                'data' => [],
            ]);
    }

    public function testReturnsInvalidPerPageResponse(): void
    {
        $response = $this->get('/groups?page=0&perPage=-1');

        $response->assertBadRequest()
            ->assertJson([
                'success' => false,
                'message' => sprintf(ErrorMessage::INVALID_PARAMETER . ': perPage must > 0', 'perPage'),
                'data' => [],
            ]);
    }

    public function testReturnsNotFoundAnyGroupsWhenPageInOverMaxTotalPagesResponse(): void
    {
        $this->seed(GroupSeeder::class);

        $response = $this->get('/groups?page=99&perPage=1');

        $response->assertNotFound()
            ->assertJson([
                'success' => false,
                'message' => sprintf(ErrorMessage::NOT_FOUND_ITEM, 'Group'),
                'data' => [],
            ]);

        GroupApi::resetTable();
    }

    public function testReturnsOkResponse(): void
    {
        $this->seed(GroupSeeder::class);

        $response = $this->get('/groups?page=0&perPage=1');

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'message' => sprintf(SuccessMessage::FOUND_LIST_ITEMS, 'Group'),
            ]);

        GroupApi::resetTable();
    }

    public function testReturnsProperDataStructure(): void
    {
        $this->seed(GroupSeeder::class);

        $response = $this->get('/groups?page=0&perPage=1');

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

        GroupApi::resetTable();
    }

    public function testReturnsProperDataValue(): void
    {
        $this->seed(GroupSeeder::class);

        $response = $this->get('/groups?page=0&perPage=2');

        $response->assertJsonPath('data.0.id', 1);
        $response->assertJsonPath('data.0.name', 'Tiếng Anh');

        $response->assertJsonPath('data.1.id', 2);
        $response->assertJsonPath('data.1.name', 'Shipper Ahamove');

        TopicApi::resetTable();
    }
}
