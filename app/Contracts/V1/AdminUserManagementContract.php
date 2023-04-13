<?php

namespace App\Contracts\V1;

use App\DataTransferObjects\AdminUserEditDto;
use App\Models\RegularUser;

interface AdminUserManagementContract
{
    public function editUser(string $userUuid, AdminUserEditDto $details): RegularUser;
}
