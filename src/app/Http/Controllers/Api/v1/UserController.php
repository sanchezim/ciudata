<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function show()
    {
        return $this->userService->showUserLogin();
    }

    public function bulkAssignUserRole()
    {
        return $this->userService->validate([
            'idUsers'   => 'required|exists:users,id',
            'roles'     => 'required|exists:roles,name'
        ])
            ->dispatchAssignUserRole()
            ->bulkAssignResponse();
    }

    public function assignUserRole ()
    {
        return $this->userService->validate([
            'idUser' => 'required|exists:users,id',
            'role'   => 'required|exists:roles,name'
        ])->assingUserRole()
        ->assignUserRoleResponse();
    }
}
