<?php

namespace Tests\Feature\Api\V1\Admin;

use App\Models\User;
use Tests\TestCase;

class AdminLoginControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        User::factory()->create([
            'is_admin' => 1,
        ]);
    }

    public function test_admin_login_is_successful(): void
    {
        $this->withoutExceptionHandling();

        $user = User::first();
        $data = [
            "email" => $user->email,
            "password" => "userpassword"
        ];

        $response = $this->postJson(route('admin.login'), $data);

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'token',
                'token_type',
            ]
        ]);
    }
}
