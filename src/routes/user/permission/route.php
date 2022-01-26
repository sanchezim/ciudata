<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\UserController;

Route::post('user/assign/permission', [UserController::class, 'assignUserPermission'])
// ->middleware(['role:super.user.master'])
->name('user.permission.assign');

Route::delete('user/revoke/permission', [UserController::class, 'revokeUserPermission'])
// ->middleware(['role:super.user.master'])
->name('user.revoke.create');

Route::post('user/bulk/assign/permission', [UserController::class, 'bulkAssignUserPermission'])
// ->middleware(['role:super.user.master'])
->name('user.bulk.permission.create');

