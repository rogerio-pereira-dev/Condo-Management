<?php

use App\Mail\User\ChangePasswordMail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ChangePasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/change-password/{uuid}', [ChangePasswordController::class, 'reset'])->name('reset-password');

Route::group([
        'auth:sanctum', 
        'middleware' => ['authenticated']
], function() {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/change-password', [ChangePasswordController::class, 'index'])->name('change-password');

    Route::get('/employees', [EmployeesController::class, 'index'])->name('employees');
});