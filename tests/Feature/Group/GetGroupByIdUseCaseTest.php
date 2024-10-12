<?php

namespace Tests\Feature\Group;

use Core\Constants\ErrorMessage;
use Core\Constants\SuccessMessage;
use Core\Features\Group\Facades\GroupApi;
use Database\Seeders\GroupSeeder;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class GetGroupByIdUseCaseTest extends TestCase
{
    use DatabaseTruncation;

    public function testReturnsProperResponseStructure(): void
    {
        $response = $this->get('/groups/444');

        $response->assertJsonStructure(['success', 'message', 'data', 'responseCode']);
    }

    public function testReturnsNotFoundResponse(): void
    {
        $response = $this->get('/groups/444');

        $response->assertNotFound()
            ->assertJson([
                'success' => false,
                'message' => sprintf(ErrorMessage::NOT_FOUND_ITEM, 'Group'),
                'data' => null,
            ]);
    }

    public function testReturnsOkResponse(): void
    {
        $this->seed(GroupSeeder::class);

        $response = $this->get('/groups/1');

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'message' => sprintf(SuccessMessage::FOUND_ITEM, 'Group'),
            ]);

        GroupApi::resetTable();
    }

    public function testReturnsProperDataStructure(): void
    {
        $this->seed(GroupSeeder::class);

        $response = $this->get('/groups/1');

        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
            ]
        ]);

        $response->assertJson(fn (AssertableJson $json) =>
        $json
            ->has('data')
            ->whereAllType([
                'data.id' => 'integer',
                'data.name' => 'string'
            ])
            ->etc());

        GroupApi::resetTable();
    }

    public function testReturnsProperDataValue(): void
    {
        $this->seed(GroupSeeder::class);

        $response = $this->get('/groups/1');

        $response->assertJsonPath('data.name', 'Tiếng Anh');

        GroupApi::resetTable();
    }
}
