<?php

use App\Http\Controllers\Api\v1\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\UserController;

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

Route::get('user', [UserController::class, 'show'])
    ->middleware(['auth:sanctum'])
    ->name('user.show');

Route::get('token/validate', [AuthController::class, 'tokenValidate'])
    ->middleware(['auth:sanctum'])
    ->name('token.validate');
