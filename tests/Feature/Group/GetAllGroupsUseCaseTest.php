<?php

namespace Tests\Feature\Group;

use Core\Constants\SuccessMessage;
use Database\Seeders\GroupSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class GetAllGroupsUseCaseTest extends TestCase
{
    use RefreshDatabase;

    public function testReturnsProperResponseStructure(): void
    {
        $response = $this->get('/groups');

        $response->assertJsonStructure(['success', 'message', 'data', 'responseCode']);
    }

    public function testReturnsNotFoundResponse(): void
    {
        $response = $this->get('/groups');

        $response->assertNotFound();
    }

    public function testReturnsOkResponse(): void
    {
        $this->seed(GroupSeeder::class);

        $response = $this->get('/groups');

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'message' => sprintf(SuccessMessage::FOUND_LIST_ITEMS, 'Group'),
            ]);
    }

    public function testReturnsProperDataStructure(): void
    {
        $this->seed(GroupSeeder::class);

        $response = $this->get('/groups');

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
                'data.0.name' => 'string'
            ])
            ->whereType('data', 'array')
            ->etc());
    }

    public function testReturnsProperDataValue(): void
    {
        $this->seed(GroupSeeder::class);

        $response = $this->get('/groups');

        $response->assertJsonCount(1, 'data');

        $response->assertJsonPath('data.0.name', 'Động vật');
    }
}
