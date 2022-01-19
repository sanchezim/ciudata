<?php

namespace App\Http\Controllers\Api\v1;

use App\Services\LoginService;
use App\Http\Controllers\Controller;

/**
 * @OA\Info(title="API Ciudata", version="1.0")
 *
 * @OA\Server(url="http://localhost:8090")
 */
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
        /**
         * @OA\Post(
         * path="/api/login",
         * operationId="authLogin",
         * tags={"Login"},
         * summary="User Login",
         * description="Login User Here",
         *     @OA\RequestBody(
         *         @OA\MediaType(
         *            mediaType="application/json",
         *            @OA\Schema(
         *               type="object",
         *               required={"email", "password"},
         *               @OA\Property(property="email", type="email"),
         *               @OA\Property(property="password", type="password")
         *            ),
         *        ),
         *    ),
         *      @OA\Response(
         *          response=200,
         *          description="Login Successfully",
         *          @OA\JsonContent()
         *       ),
         *      @OA\Response(response=400, description="Bad request"),
         *      @OA\Response(response=404, description="Resource Not Found"),
         * )
         */
        return $this->loginService
            ->setUser()
            ->checkHash()
            ->setToken()
            ->loginResponse();
    }
}
