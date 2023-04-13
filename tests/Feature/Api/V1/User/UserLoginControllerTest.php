<?php

namespace Tests\Feature\Api\V1\User;

use App\Models\User;
use Tests\TestCase;

class UserLoginControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        User::factory()->create([
            'is_admin' => 0,
        ]);
    }

    /**
     * Test the login endpoint.
     *
     * @return void
     */
    public function test_user_login_is_successful(): void
    {
        $this->withoutExceptionHandling();

        $user = User::first();
        $data = [
            "email" => $user->email,
            "password" => "userpassword"
        ];

        $response = $this->postJson(route('user.login'), $data);

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'token',
                'token_type',
            ]
        ]);
    }
}
