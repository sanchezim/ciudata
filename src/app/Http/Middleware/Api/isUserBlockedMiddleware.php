<?php

namespace App\Http\Middleware\Api;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Requests\LoginRequest;
use App\Http\Traits\ApiResponseTrait;
use Illuminate\Validation\ValidationException;

class isUserBlockedMiddleware
{
    use ApiResponseTrait;

    protected UserService $userService;
    protected User $user;

    public function __construct(LoginRequest $request, UserService $userService)
    {
        $this->userService = $userService;
        $this->setUser($this->userService->getUserByEmail($request->email));
    }

    public function setUser(User $user)
    {
        $this->user = $user;
    }
    

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->user->isBlocked()) {
            return $this->unauthorizedResponse(
                __('Disabled user')
            );
        }
        return $next($request);
    }
}
