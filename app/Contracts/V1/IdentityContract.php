<?php

namespace App\Contracts\V1;

use App\DataTransferObjects\LoginDto;
use App\Results\LoginResult;

interface IdentityContract
{
    public function login(LoginDto $credentials): LoginResult;
    public function logout(): void;
}
