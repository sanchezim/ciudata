<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\UserController;

Route::post('user/bulk/assign/role', [UserController::class, 'bulkAssignUserRole'])
    // ->middleware(['role:super.user.master'])
    ->name('user.bulk.role.assign');

Route::post('user/assign/role', [UserController::class, 'assignUserRole'])
    // ->middleware(['role:super.user.master'])
    ->name('user.role.assign');


Route::delete('user/revoke/role', [UserController::class, 'revokeUserRole'])
// ->middleware(['role:super.user.master'])
->name('user.role.revoke');
