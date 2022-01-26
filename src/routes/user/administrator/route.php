<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\User\UserAdministratorController;

Route::post('/create', [UserAdministratorController::class, 'create'])
    ->name('user.administrator.create');
