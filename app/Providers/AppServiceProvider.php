<?php

namespace App\Providers;

use App\Contracts\V1\IdentityContract;
use App\Contracts\V1\UserManagementContract;
use App\Interfaces\JwtServiceInterface;
use App\Services\JwtService;
use App\Services\V1\UserManagementService;
use Illuminate\Support\ServiceProvider;
use App\Services\V1\IdentityService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IdentityContract::class, IdentityService::class);
        $this->app->bind(JwtServiceInterface::class, JwtService::class);
        $this->app->bind(UserManagementContract::class, UserManagementService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
