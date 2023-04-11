<?php

namespace App\Results;

class LoginResult
{
    public string $token;
    public string $token_type;

    public function __construct(string $token, string $token_type){
        $this->token = $token;
        $this->token_type = $token_type;
    }
}
