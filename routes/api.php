<?php

use App\Http\Controllers\Api\V1\Admin\AdminLoginController;
use App\Http\Controllers\Api\V1\Admin\AdminLogoutController;
use App\Http\Controllers\Api\V1\Admin\AdminRegistrationController;
use App\Http\Controllers\Api\V1\Admin\UserDeleteController;
use App\Http\Controllers\Api\V1\Admin\UserEditController;
use App\Http\Controllers\Api\V1\Admin\UserListingController;
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
        Route::get('/logout', UserLogoutController::class)->name('user.logout');
    });
});

Route::group(['prefix' => '/v1/admin'], function () {
    Route::post('/login', AdminLoginController::class)->name('admin.login');
    Route::post('/create', AdminRegistrationController::class)->name('admin.create');

    Route::group(['middleware' => ['auth.jwt', 'admin']], function () {
        Route::get('/logout', AdminLogoutController::class)->name('admin.logout');
        Route::get('/user-listing', UserListingController::class)->name('admin.user-listing');

        Route::put('/user-edit/{uuid}', UserEditController::class)->name('admin.user-edit');
        Route::delete('/user-delete/{uuid}', UserDeleteController::class)->name('admin.user-delete');
    });
});
