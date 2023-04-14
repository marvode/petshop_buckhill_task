<?php

namespace App\Contracts\V1;

use App\DataTransferObjects\UserEditDto;
use App\Models\RegularUser;

interface UserAccountManagementContract
{
    public function edit(UserEditDto $details, string $loggedInUserUuid): RegularUser;
    public function show(string $loggedInUserUuid): RegularUser;
    public function delete(string $loggedInUserUuid): void;
}
