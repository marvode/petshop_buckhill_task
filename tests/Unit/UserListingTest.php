<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\V1\UserManagementService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserListingTest extends TestCase
{
    use RefreshDatabase;

    private UserManagementService $userManagementService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userManagementService = app(UserManagementService::class);
    }

    public function test_can_get_all_regular_users_with_filters_and_pagination_as_admin()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create([
            'is_admin' => true,
        ]);

        $this->actingAs($user);

        $userCount = 10;
        User::factory()->count($userCount)->create([
            'is_admin' => false,
            'is_marketing' => true,
        ]);

        $page = 1;
        $limit = 2;
        $sort = 'created_at';
        $desc = true;
        $first_name = '';
        $last_name = '';
        $email = '';
        $phone_number = '';
        $is_marketing = true;
        $created_at = '';

        $result = $this->userManagementService->getAllUsers($page, $limit, $sort, $desc, $first_name, $last_name,
                                                            $email, $phone_number, $is_marketing, $created_at);

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertEquals($result->total(), $userCount);
        $this->assertEquals($result->perPage(), $limit);
        $this->assertEquals($result->currentPage(), $page);
        $this->assertTrue($result->hasMorePages());
    }
}
