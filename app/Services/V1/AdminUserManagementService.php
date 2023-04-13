<?php

namespace App\Services\V1;

use App\Contracts\V1\AdminUserManagementContract;
use App\DataTransferObjects\AdminUserEditDto;
use App\Models\RegularUser;
use Illuminate\Support\Facades\Hash;

class AdminUserManagementService implements AdminUserManagementContract
{

    public function editUser(string $userUuid, AdminUserEditDto $details): RegularUser
    {
        $user = RegularUser::where('uuid', $userUuid)->firstOrFail();

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
}
