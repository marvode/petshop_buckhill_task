<?php

namespace App\Models;

use App\Models\Scopes\AdminUserScope;

class AdminUser extends User
{
    protected $table = 'users';

    protected static function boot(): void
    {
        parent::boot();
        static::addGlobalScope(new AdminUserScope);
    }
}
