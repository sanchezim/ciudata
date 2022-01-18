<?php

namespace App\Http\Controllers\Api\v1;

use App\Services\LoginService;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{

    protected LoginService $loginService;

    public function __construct(LoginService $loginService)
    {
        $this->middleware(['isUserBlocked']);
        
        $this->loginService = $loginService;
    }

    public function login()
    {
        return $this->loginService
            ->setUser()
            ->checkHash()
            ->setToken()
            ->loginResponse();
    }
}
