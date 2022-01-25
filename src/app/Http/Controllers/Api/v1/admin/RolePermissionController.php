<?php

namespace App\Http\Controllers\Api\v1\admin;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;
use App\Http\Resources\RoleCollection;
use Spatie\Permission\Models\Permission;

class RolePermissionController extends Controller
{

    public function indexRole()
    {
        return new RoleCollection(Role::paginate());
    }

    public function createRole(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $role        = Role::create(['guard_name' => 'web', 'name' => $request->name]);
        return new RoleResource($role);
    }

    public function updateRole(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required'
        ]);
        $role->name = $request->name;
        $role->save();

        return new RoleResource($role);
    }

    public function deleteRole(Role $role)
    {
        $model = $role;
        $role->delete();
        return new RoleResource($model);
    }

    public function createPermission(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $permission = Permission::create(['guard_name' => 'web', 'name' => $request->name]);
        
        return new RoleResource($permission);
    }
}
