<?php

namespace App\Models;

use App\Models\Scopes\RegularUserScope;

class RegularUser extends User
{
    protected $table = 'users';

    protected static function boot(): void
    {
        parent::boot();
        static::addGlobalScope(new RegularUserScope);
    }
}
