<?php

namespace App\Contracts\V1;

use App\DataTransferObjects\AdminUserEditDto;
use App\Models\RegularUser;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface AdminUserManagementContract
{

    public function getAllUsers(
        int $page,
        int $limit,
        string $sort,
        bool $desc,
        string $first_name,
        string $last_name,
        string $email,
        string $phone_number,
        bool|null $is_marketing,
        string $created_at
    ): LengthAwarePaginator;

    public function editUser(string $userUuid, AdminUserEditDto $details): RegularUser;

    public function deleteUser(string $uuid): void;
}
