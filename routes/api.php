<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\User\UserController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\User\ChangePasswordController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['auth:sanctum'], function(){
    Route::post('/logout', [LogoutController::class, 'logout']);

    Route::post('/user/change-password/request', [ChangePasswordController::class, 'requestChangePassword']);
    Route::post('/user/change-password/reset', [ChangePasswordController::class, 'resetPassword']);
    Route::post('/user/change-password', [ChangePasswordController::class, 'changePassword']);
    
    Route::get('/user/category/{category?}', [UserController::class, 'index']);
    Route::apiResource('/user', UserController::class);
});


Route::post('/login', [LoginController::class, 'login']);