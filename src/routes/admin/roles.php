<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\admin\RolePermissionController;

Route::get('/', [RolePermissionController::class, 'index'])
    ->name('admin.role.index');

Route::post('/create', [RolePermissionController::class, 'create'])
    ->name('admin.role.create');

Route::put('/update/{role}', [RolePermissionController::class, 'update'])
    ->name('admin.role.update');

Route::delete('/delete/{role}', [RolePermissionController::class, 'delete'])
    ->name('admin.role.delete');
