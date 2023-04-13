<?php

namespace App\DataTransferObjects;

use App\Http\Requests\V1\LoginRequest;

class LoginDto
{
    public string $email;
    public string $password;
    public bool $is_admin;

    public function __construct(string $email, string $password, bool $is_admin)
    {
        $this->email = $email;
        $this->password = $password;
        $this->is_admin = $is_admin;
    }

    public static function fromRequest(LoginRequest $request, bool $is_admin = false): static
    {
        return new static($request->email, $request->password, $is_admin);
    }
}
