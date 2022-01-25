<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\Permission\PermissionController;

Route::get('/', [PermissionController::class, 'index'])
    ->name('role.index');
