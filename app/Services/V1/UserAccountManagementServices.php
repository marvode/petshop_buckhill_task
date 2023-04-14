<?php

namespace App\Services\V1;

use App\Contracts\V1\UserAccountManagementContract;
use App\DataTransferObjects\UserEditDto;
use App\Models\RegularUser;
use Illuminate\Support\Facades\Hash;

class UserAccountManagementServices implements UserAccountManagementContract
{
    public function edit(UserEditDto $details, string $loggedInUserUuid): RegularUser
    {
        $user = RegularUser::where('uuid', $loggedInUserUuid)->firstOrFail();

        $user->update([
            'first_name' => $details->first_name,
            'last_name' => $details->last_name,
            'email' => $details->email,
            'password' => Hash::make($details->password),
            'address' => $details->address,
            'phone_number' => $details->phone_number,
            'avatar' => $details->avatar,
            'is_marketing' => $details->is_marketing,
        ]);

        return $user;
    }

    public function show(string $loggedInUserUuid): RegularUser
    {
        $user = RegularUser::where('uuid', $loggedInUserUuid)->firstOrFail();

        return $user;
    }
}
