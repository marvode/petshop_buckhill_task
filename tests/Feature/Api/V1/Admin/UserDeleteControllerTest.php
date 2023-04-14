<?php

namespace Tests\Feature\Api\V1\Admin;

use App\Models\User;
use Tests\TestCase;

class UserDeleteControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_deletes_user_and_returns_success_response_with_204_status_code()
    {
        $this->withoutExceptionHandling();
        $this->withoutMiddleware();

        $userUuid = '1234567890abcdef';

        User::factory()->create([
            'uuid' => $userUuid,
            'is_admin' => 0,
        ]);

        $response = $this->deleteJson(route('admin.user-delete', $userUuid));
        $userCount = User::where('uuid', $userUuid)->count();

        $response->assertNoContent();
        $this->assertEquals(0, $userCount);
    }
}
