<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\User;
use App\Services\PasswordService;

class UserService
{
    protected User $user;
    protected PasswordService $passwordService;

    public function __construct(User $user, PasswordService $passwordService)
    {
        $this->user            = $user;
        $this->passwordService = $passwordService;
    }

    public function getUserByEmail(string $email): User
    {
        return $this->user::where('email', $email)
            ->first();
    }

    public function attemptUser(User $user): void
    {
        $user->number_attempt_login = ($user->number_attempt_login + 1);
        $user->save();
        $this->blockedUser($user);
    }

    public function blockedUser(User $user): void
    {
        if ($user->number_attempt_login >= config('apiConfig.USER_LOGIN_ATTEMPTS')) {
            $user->blocked = true;
            $user->save();
            $this->sendForgotPassword($user->email);
        }
    }

    public function sendForgotPassword(string $email): void
    {
        $this->passwordService->setEmail($email)->sendResetLink();
    }

    public function showUserLogin()
    {
        return auth()->user();
    }

    public function setLastLogin(User $user): void
    {
        $user->last_login_at = Carbon::now();
        $user->save();
    }

    public function resetAttempts(User $user): void
    {
        $user->number_attempt_login = 0;
        $user->save();
    }
}
