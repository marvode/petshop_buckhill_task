<?php

use App\Http\Controllers\Api\V1\Admin\AdminLoginController;
use App\Http\Controllers\Api\V1\User\UserLoginController;
use App\Http\Controllers\Api\V1\User\UserLogoutController;
use App\Http\Controllers\Api\V1\User\UserRegistrationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix' => '/v1/user'], function () {
    Route::post('/login', UserLoginController::class)->name('user.login');
    Route::post('/create', UserRegistrationController::class)->name('user.create');

    Route::group(['middleware' => ['auth.jwt', 'user']], function () {
        Route::middleware('auth.jwt')->get('/logout', UserLogoutController::class)->name('user.logout');
    });
});

Route::group(['prefix' => '/v1/admin'], function () {
    Route::post('/login', AdminLoginController::class)->name('admin.login');
});
