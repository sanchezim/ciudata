<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\Role\RoleController;

// Route::post('/permission/create', [RolePermissionController::class, 'createPermission'])
//     ->name('admin.permission.create');

// Route::post('/permission/update', [RolePermissionController::class, 'updatePermission'])
//     ->name('admin.permission.update');

// Route::post('/permission/delete', [RolePermissionController::class, 'deletePermission'])
//     ->name('admin.permission.delete');

// Route::post('/permission', [RolePermissionController::class, 'indexPermission'])
//     ->name('admin.permission.index');


// // Route::controller(RoleController::class)->group(function () {
// //     Route::get('/', 'index')->name('role.index');
// // });

// Route::controller(RoleController::class)->group(function () {
//     Route::get('/', 'index');
//     Route::post('/orders', 'store');
// });



Route::get('/', [RoleController::class, 'index'])
    ->name('role.index');

Route::get('/{role}', [RoleController::class, 'show'])
    ->name('role.show');

Route::patch('/{role}', [RoleController::class, 'assignPermissions'])
    ->name('role.assign.permissions');

Route::delete('/{role}', [RoleController::class, 'revokePermissions'])
    ->name('role.revoke.permissions');




// Route::post('/role/create', [RolePermissionController::class, 'createRole'])
//     ->name('admin.role.create');

// Route::put('/role/update/{role}', [RolePermissionController::class, 'updateRole'])
//     ->name('admin.role.update');

// Route::delete('/role/delete/{role}', [RolePermissionController::class, 'deleteRole'])
//     ->name('admin.role.delete');
