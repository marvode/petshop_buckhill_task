<?php

namespace Tests\Feature\Api\V1\User;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserRegistrationControllerTest extends TestCase
{
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Test the user registration endpoint.
     *
     * @return void
     */
    public function test_user_registration_successful(): void
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

        $response = $this->postJson(route('user.create'), $data);

        $user = User::first();

        $response->assertCreated();
        $this->assertFalse(!!$user->is_admin);
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
