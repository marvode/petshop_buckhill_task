<?php

namespace App\Contracts\V1;

use App\DataTransferObjects\AdminRegisterDto;
use App\DataTransferObjects\LoginDto;
use App\DataTransferObjects\UserRegisterDto;
use App\Models\AdminUser;
use App\Models\RegularUser;
use App\Results\LoginResult;

interface IdentityContract
{
    public function login(LoginDto $credentials): LoginResult;
    public function logout(): void;
    public function userRegisteration(UserRegisterDto $userDetails): RegularUser;
    public function adminRegisteration(AdminRegisterDto $details): AdminUser;
}
