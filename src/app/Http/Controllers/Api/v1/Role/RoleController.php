<?php

namespace App\Http\Controllers\Api\v1\Role;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoleCollection;
use App\Http\Resources\RoleResource;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        return new RoleCollection(Role::all());
    }

    public function show(Role $role)
    {
        return new RoleResource($role);
    }

    public function assignPermissions(Request $request, Role $role)
    {
        $request->validate([
            'permissions' => 'required|exists:permissions,name'
        ]);
        $permissions = Permission::where($request->permissions);
        $role->syncPermissions($permissions);
    }
}
