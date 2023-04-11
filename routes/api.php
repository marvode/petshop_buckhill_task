<?php

use App\Http\Controllers\Api\V1\UserLoginController;
use App\Http\Controllers\Api\V1\UserLogoutController;
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
    Route::post('/login', UserLoginController::class);

    Route::group(['middleware' => ['auth.jwt', 'user']], function () {
        Route::middleware('auth.jwt')->post('/logout', UserLogoutController::class);
    });
});
