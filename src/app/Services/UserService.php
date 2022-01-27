<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Jobs\BulkAssignUserRole;
use App\Http\Traits\ServiceTrait;
use App\Services\PasswordService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Traits\ApiResponseTrait;
use App\Jobs\BulkAssignUserPermission;
use App\Http\Resources\User\UserResource;
use App\Services\Interface\ServiceInterface;
use App\Notifications\User\Verify\EmailVerificationNotification;

class UserService implements ServiceInterface
{
    use ServiceTrait, ApiResponseTrait;

    protected User $user;
    protected PasswordService $passwordService;

    protected  string|int $passwordSend;

    public function __construct(User $user, PasswordService $passwordService, Request $request)
    {
        $this->user            = $user;
        $this->passwordService = $passwordService;
        $this->request         = $request;
        $this->message         = 'Request accepted';
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
        return $this->auth()->user();
    }

    public function auth()
    {
        return Auth::guard('sanctum');
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
            $user->syncRoles($roles);
        }
    }

    public function assingUserRole()
    {
        $this->getUserById($this->request->idUser)->syncRoles($this->request->role);
        return $this;
    }

    public function bulkAssignResponse()
    {
        return $this->serviceResponse([
            'code'      => $this->code,
            'message'   => __($this->message),
        ]);
    }

    public function assignUserRoleResponse()
    {
        return $this->serviceResponse([
            'code'      => $this->code,
            'message'   => __($this->message),
        ]);
    }

    public function assignUserPermission(): self
    {
        $this->getUserById($this->request->idUser)->givePermissionTo($this->request->permission);
        return $this;
    }

    public function assignUserPermissionResponse()
    {
        return $this->serviceResponse([
            'code'      => $this->code,
            'message'   => __($this->message),
        ]);
    }

    public function dispatchAssignUserPermission(): self
    {
        BulkAssignUserPermission::dispatch($this->request->idUsers, $this->request->permissions);
        return $this;
    }

    public function bulkAssignUserPermission(array $idUsers, array $permissions)
    {
        foreach ($idUsers  as  $idUser) {
            $this->getUserById($idUser)->givePermissionTo($permissions);
        }
    }

    public function revokeUSerPermission()
    {
        $this->getUserById($this->request->idUser)->revokePermissionTo($this->request->permissions);
        return $this;
    }

    public function revokeUserRole()
    {
        $this->getUserById($this->request->idUser)->removeRole($this->request->role);
        return $this;
    }

    public function sendVerifyEmail(User $user = null): self
    {
        $user = $user ?? $this->user;
        $user->notify(new EmailVerificationNotification($this->passwordSend));
        return $this;
    }

    public function save()
    {
        $this->user = $this->user->saveUser($this->requestValidated);
        return $this;
    }

    public function saveReponse()
    {
        return $this->serviceResponse([
            'code'      => $this->code,
            'message'   => __($this->message),
            'data'      => new UserResource($this->user),
        ]);
    }

    public function setPasswordRandom()
    {
        $this->passwordSend  = helper_random_string();
        $this->requestValidated['password'] = Hash::make($this->passwordSend);
        return $this;
    }

    /**
     * Get the value of user
     */ 
    public function getUser()
    {
        return $this->user;
    }
}
