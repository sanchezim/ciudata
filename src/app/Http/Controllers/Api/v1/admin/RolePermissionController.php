<?php

namespace App\Http\Controllers\Api\v1\admin;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoleCollection;
use App\Http\Resources\RoleResource;

class RolePermissionController extends Controller
{

    public function index()
    {
        return new RoleCollection(Role::paginate());
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $role = Role::create(['guard_name' => 'web', 'name' => $request->name]);

        return new RoleResource($role);
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required'
        ]);
        $role->name = $request->name;
        $role->save();

        return new RoleResource($role);
    }

    public function delete(Role $role)
    {
        $model = $role;
        $role->delete();
        return new RoleResource($model);
    }
}
