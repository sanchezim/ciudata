<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Traits\ServiceTrait;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Resources\User\UserResource;
use Illuminate\Validation\ValidationException;

class LoginService
{
    use ApiResponseTrait, ServiceTrait;

    protected bool $checkHash = true;
    protected string $token;

    protected UserService $userService;
    protected User $user;

    public function __construct(Request $request, UserService $userService)
    {
        $this->request      = $request;
        $this->userService  = $userService;
        $this->message      = 'Request accepted';
    }

    public function setUser(): self
    {
        $this->user = $this->getUserByEmail();
        return $this;
    }

    public function getUserByEmail()
    {
        return $this->userService->getUserByEmail($this->request->email);
    }

    public function checkHash(): self
    {
        if (!Hash::check($this->request->password, $this->user->password)) {
            $this->checkHash = false;
            $this->userService->attemptUser($this->user);

            throw ValidationException::withMessages([
                'email' => __('The password is incorrect, on the :tried invalid attempt your user is blocked: attempt :userAttempt of :tried', [
                    'tried'         => config('apiConfig.USER_LOGIN_ATTEMPTS'),
                    'userAttempt'   => $this->user->number_attempt_login
                ]),
            ]);
        }
        return $this;
    }

    public function setToken(): self
    {
        $this->token =  $this->user->createToken('auth_user')->plainTextToken;
        return $this;
    }

    public function login()
    {
        if (!Auth::attempt(['email' => $this->request->email, 'password' => $this->request->password])) {
            throw ValidationException::withMessages([
                'email' => __('The password is incorrect, on the :tried invalid attempt your user is blocked: attempt :userAttempt of :tried', [
                    'tried'         => config('apiConfig.USER_LOGIN_ATTEMPTS'),
                    'userAttempt'   => $this->user->number_attempt_login
                ]),
            ]);
        }

        return $this;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function loginResponse()
    {
        $this->userService->setLastLogin($this->user);
        $this->userService->resetAttempts($this->user);

        return $this->serviceResponse([
            'code'        => $this->code,
            'message'     => __($this->message),
            'accessToken' => $this->token,
            'data'        => new UserResource($this->userService->auth()->user())
        ]);
    }

    public function tokenValidateResponse()
    {
        return $this->serviceResponse([
            'code'          => $this->code,
            'message'       => __($this->message),
            'tokenValidate' => true,
        ]);
    }

    public function logout(): self
    {
        $auth = $this->userService->auth();
        if ($auth->check()) {
            optional($auth->user())->currentAccessToken()->delete();
        }
        return $this;
    }

    public function logoutResponse()
    {
        return $this->serviceResponse([
            'code'      => $this->code,
            'message'   => __($this->message)
        ]);
    }
}
