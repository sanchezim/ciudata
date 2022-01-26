<?php

namespace App\Http\Controllers\Api\v1\Role;

use Illuminate\Http\Request;
use App\Services\RoleService;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;
use App\Http\Resources\RoleCollection;

class RoleController extends Controller
{

    protected RoleService $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function index()
    {
        return new RoleCollection(Role::all());
    }

    public function show(Role $role)
    {
        return new RoleResource($role);
    }

    public function assignPermissions(Role $role)
    {
        return $this->roleService
        ->validate([
            'permissions' => 'required|exists:permissions,name'
        ])
        ->setRole($role)
        ->givePermission()
        ->assignPermissionsResponse();
    }

    public function revokePermissions(Role $role)
    {
        return $this->roleService
        ->validate([
            'permissions' => 'required|exists:permissions,name'
        ])
        ->setRole($role)
        ->revokePermissions()
        ->revokePermissionsResponse();
    }
}
