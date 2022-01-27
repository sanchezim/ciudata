<?php

namespace App\Http\Controllers\Api\v1\User;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserCollection;
use App\Http\Requests\User\UserAdminitratorRequest;

class UserAdministratorController extends Controller
{

    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function create(UserAdminitratorRequest $request)
    {
        return $this->userService
            ->setRequestValidated($request->validated())
            ->setPasswordRandom()
            ->save()
            ->sendVerifyEmail()
            ->saveReponse();
    }

    public function index(Request $request)
    {
        $request->validate([
            'perPage' => 'required|int',
            'orderBy' => 'required|array'
        ]);
        $orderBy = $request->orderBy;
        return new UserCollection($this->userService->getUser()::orderBy($orderBy['field'], $orderBy['order'])
            ->whereProfile($request->idProfile)
            ->whereFullName($request->fullName)
            ->paginate($request->perPage));
    }
}
