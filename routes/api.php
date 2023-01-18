<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\User\UserController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;

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

    Route::apiResource('/user', UserController::class);
    Route::get('/user/category/{category?}', [UserController::class, 'index']);
});


Route::post('/login', [LoginController::class, 'login']);