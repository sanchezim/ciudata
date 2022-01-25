
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\NewPasswordController;

Route::post('login', [AuthController::class, 'login'])
    ->middleware(['isUserBlocked'])
    ->name('login');

Route::post('forgot/password', [NewPasswordController::class, 'forgotPassword'])
    ->middleware('guest')
    ->name('password.email');

Route::post('reset/password', [NewPasswordController::class, 'resetPassword'])
    ->name('password.reset');
