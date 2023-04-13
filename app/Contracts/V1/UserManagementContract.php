<?php

namespace App\Contracts\V1;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface UserManagementContract
{
    public function getAllUsers(int $page, int $limit, string $sort, bool $desc, string $first_name, string $last_name,
                                string $email, string $phone_number, bool|null $is_marketing, string $created_at): LengthAwarePaginator;
}
