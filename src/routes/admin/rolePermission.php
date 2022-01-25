<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\admin\RolePermissionController;


Route::post('/permission/create', [RolePermissionController::class, 'createPermission'])
    ->name('admin.permission.create');

Route::post('/permission/update', [RolePermissionController::class, 'updatePermission'])
->name('admin.permission.update');

Route::post('/permission/delete', [RolePermissionController::class, 'deletePermission'])
->name('admin.permission.delete');

Route::post('/permission', [RolePermissionController::class, 'indexPermission'])
->name('admin.permission.index');



    

Route::get('/role', [RolePermissionController::class, 'indexRole'])
    ->name('admin.role.index');

Route::post('/role/create', [RolePermissionController::class, 'createRole'])
    ->name('admin.role.create');

Route::put('/role/update/{role}', [RolePermissionController::class, 'updateRole'])
    ->name('admin.role.update');

Route::delete('/role/delete/{role}', [RolePermissionController::class, 'deleteRole'])
    ->name('admin.role.delete');
