<?php

namespace Tests\Feature\Group;

use Core\Constants\SuccessMessage;
use Tests\TestCase;

class GetAllGroupsUseCaseTest extends TestCase
{
    public function testReturnsOkResponse(): void
    {
        $response = $this->get('/groups');

        $response->assertJsonStructure(['success', 'message', 'data', 'responseCode']);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'success' => true,
                'message' => sprintf(SuccessMessage::FOUND_LIST_ITEMS, 'Group'),
            ]);
    }

    public function testReturnsProperData(): void
    {
        $response = $this->get('/groups');

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                ]
            ]
        ]);

        $response->assertJsonPath('data.0.id', 1);
        $response->assertJsonPath('data.0.name', 'Động vật');
    }
}
