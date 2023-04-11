<?php

namespace App\Providers;

use App\Contracts\V1\IdentityContract;
use App\Interfaces\JwtServiceInterface;
use App\Services\JwtService;
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
