<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\UserController;
use App\Http\Controllers\Api\v1\NewPasswordController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', [AuthController::class, 'login'])
    ->middleware(['isUserBlocked'])
    ->name('user.login');

Route::post('forgot/password', [NewPasswordController::class, 'forgotPassword'])
    ->middleware('guest')
    ->name('password.email');

Route::post('reset/password', [NewPasswordController::class, 'resetPassword'])->name('password.reset');


Route::post('user/assign/role', [UserRoleController::class, 'assign'])->name('user.role.assign');



Route::get('user', [UserController::class, 'show'])
    ->middleware(['auth:sanctum'])
    ->name('user.show');
