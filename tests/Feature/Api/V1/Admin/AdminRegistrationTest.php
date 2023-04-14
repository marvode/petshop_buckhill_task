<?php

namespace Tests\Feature\Api\V1\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminRegistrationTest extends TestCase
{
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_admin_creation_call_creates_admin_user(): void
    {
        $this->withoutExceptionHandling();

        $data = [
            "first_name" => $this->faker->firstName,
            "last_name" => $this->faker->lastName,
            "email" => $this->faker->email,
            "password" => 'password',
            "password_confirmation" => 'password',
            "phone_number" => $this->faker->phoneNumber,
            "address" => $this->faker->address,
        ];

        $response = $this->postJson(route('admin.create'), $data);

        $user = User::first();

        $response->assertCreated();
        $this->assertTrue(!!$user->is_admin);
        $this->assertDatabaseHas('users', [
            'email' => $data['email']
        ]);
        $response->assertJsonStructure([
            'data' => [
                'uuid',
                'first_name',
                'last_name',
                'email'
            ]
        ]);
    }
}
