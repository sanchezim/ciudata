<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\UserController;

Route::post('user/bulk/assign/role', [UserController::class, 'bulkAssignUserRole'])
    ->middleware(['auth:sanctum', 'role:super.user.master'])
    ->name('user.bulk.role.create');

Route::post('user/assign/role', [UserController::class, 'assignUserRole'])
    ->middleware(['auth:sanctum', 'role:super.user.master'])
    ->name('user.role.permission.create');