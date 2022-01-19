<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Services\PasswordService;

class NewPasswordController extends Controller
{

    protected PasswordService $passwordService;

    public function __construct(PasswordService $passwordService)
    {
        $this->passwordService = $passwordService;
    }

    public function forgotPassword()
    {
        return $this->passwordService
            ->validate(['email' => 'required|email|exists:users'])
            ->setEmail()
            ->sendResetLink()
            ->forgotResponse();
    }

    public function resetPassword()
    {
        return $this->passwordService->validate([
            'token'     => 'required',
            'email'     => 'required|email|exists:users',
            'password'  => 'required|min:8|confirmed',
        ])
        ->resetPassword()
        ->resetPasswordResponse();
    }
}
