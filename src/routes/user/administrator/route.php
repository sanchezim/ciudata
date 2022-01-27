<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\User\UserAdministratorController;

Route::post('/create', [UserAdministratorController::class, 'create'])
    ->middleware(['role:super.user.master|super.user.senior'])
    ->name('user.administrator.create');


Route::post('/', [UserAdministratorController::class, 'index'])
    // ->middleware(['role:super.user.master|super.user.senior'])
    ->name('user.administrator.index');
