<?php

namespace App\DataTransferObjects;

use App\Http\Requests\Api\V1\UserEditRequest;

class UserEditDto
{
    public string $first_name;
    public string $last_name;
    public string $email;
    public string $password;
    public string $address;
    public string $phone_number;
    public string|null $avatar;
    public bool $is_marketing;

    public function __construct(
        string $first_name,
        string $last_name,
        string $email,
        string $password,
        string $address,
        string $phone_number,
        string|null $avatar,
        bool $is_marketing
    ) {
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email = $email;
        $this->password = $password;
        $this->address = $address;
        $this->phone_number = $phone_number;
        $this->avatar = $avatar;
        $this->is_marketing = $is_marketing;
    }

    public static function fromRequest(UserEditRequest $request): static
    {
        return new static(
            $request->first_name,
            $request->last_name,
            $request->email,
            $request->password,
            $request->address,
            $request->phone_number,
            $request->avatar,
            $request->is_marketing ?? false
        );
    }
}
