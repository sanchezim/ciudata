<?php

namespace App\Services;

use App\Http\Traits\ApiResponseTrait;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Jobs\BulkAssignUserRole;
use App\Http\Traits\ServiceTrait;
use App\Services\PasswordService;
use Spatie\Permission\Models\Role;
use App\Services\Interface\ServiceInterface;

class UserService implements ServiceInterface
{
    use ServiceTrait, ApiResponseTrait;

    protected User $user;
    protected PasswordService $passwordService;

    public function __construct(User $user, PasswordService $passwordService, Request $request)
    {
        $this->user            = $user;
        $this->passwordService = $passwordService;
        $this->request         = $request;
        $this->message         = __('Request accepted');
    }

    public function validate(array $rules): self
    {
        $this->request->validate($rules);
        return $this;
    }

    public function getUserByEmail(string $email): User
    {
        return $this->user::where('email', $email)
            ->first();
    }

    public function getUserById(int $id): User
    {
        return $this->user->find($id);
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

    public function dispatchAssignUserRole(): self
    {
        BulkAssignUserRole::dispatch($this->request->idUsers, $this->request->roles);
        return $this;
    }

    public function bulkAssignUserRole(array $idUsers, array $roles)
    {
        foreach ($idUsers  as  $idUser) {
            $user = $this->getUserById($idUser);
            // $user->assignRole($role);
            $user->syncRoles($roles);
        }
    }

    public function bulkAssignResponse()
    {
        return $this->serviceResponse([
            'code' => $this->code,
            'message' => $this->message,
        ]);
    }
}
