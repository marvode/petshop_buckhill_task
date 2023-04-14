<?php

namespace Tests\Feature\Api\V1\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserEditControllerTest extends TestCase
{
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_edit_user_details_from_admin_account(): void
    {
        $this->withoutMiddleware();
        $this->withoutExceptionHandling();

        $admin = User::factory()->create([
            'is_admin' => 1,
        ]);
        $this->actingAs($admin);
        $user = User::factory()->create([
            'is_admin' => 0,
        ]);
        $newPhone = $this->faker->phoneNumber;

        $details = [
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'password' => 'password',
            'password_confirmation' => 'password',
            'address' => $user->address,
            'phone_number' => $newPhone,
            'is_marketing' => $user->is_marketing,
            'avatar' => $user->avatar,
        ];

        $response = $this->putJson(route('admin.user-edit', $user->uuid), $details);

        $response->assertOk();
        $this->assertDatabaseHas('users', [
            'phone_number' => $newPhone
        ]);
    }
}

