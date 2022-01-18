<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UserService
{
    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
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
        }
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
}
