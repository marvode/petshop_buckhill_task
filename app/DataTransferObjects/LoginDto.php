<?php

namespace App\DataTransferObjects;

use App\Http\Requests\V1\LoginRequest;

class LoginDto
{
    public string $email;
    public string $password;

    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public static function fromRequest(LoginRequest $request): static
    {
        return new static($request->email, $request->password);
    }
}
