<?php

namespace App\Services\V1;

use App\Contracts\V1\AdminUserManagementContract;
use App\DataTransferObjects\AdminUserEditDto;
use App\Models\RegularUser;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
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

    public function getAllUsers(int $page, int $limit, string $sort, bool $desc, string $first_name, string $last_name, string $email, string $phone_number, ?bool $is_marketing, string $created_at): LengthAwarePaginator
    {
        $query = RegularUser::query();

        if ($first_name)
            $query->where('first_name', 'like', "%$first_name%");
        if ($last_name)
            $query->where('last_name', 'like', "%$last_name%");
        if ($email)
            $query->where('email', 'like', "%$email%");
        if ($phone_number)
            $query->where('phone_number', 'like', "%$phone_number%");
        if ($is_marketing)
            $query->where('is_marketing', $is_marketing);
        if ($created_at)
            $query->whereDate('created_at', $created_at);

        if ($desc)
            return $query->orderByDesc($sort)->paginate($limit, ['*'], 'page', $page);
        return $query->orderBy($sort)->paginate($limit, ['*'], 'page', $page);
    }

    public function deleteUser(string $uuid): void
    {
        $user = RegularUser::where('uuid', $uuid)->firstOrFail();

        $user->delete();
    }
}
