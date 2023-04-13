<?php

namespace App\Services\V1;

use App\Contracts\V1\UserManagementContract;
use App\Models\RegularUser;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserManagementService implements UserManagementContract
{
    public function getAllUsers(int    $page, int $limit, string $sort, bool $desc, string $first_name, string $last_name,
                                string $email, string $phone_number, bool|null $is_marketing, string $created_at): LengthAwarePaginator
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
}
