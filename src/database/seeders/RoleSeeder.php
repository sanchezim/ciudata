<?php

namespace Database\Seeders;

use App\Services\RolePermissionService;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{

    protected RolePermissionService $rolePermissionService;

    public function __construct(RolePermissionService $rolePermissionService)
    {
        $this->rolePermissionService = $rolePermissionService;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rolePermission  = $this->rolePermissionService;

        /**
         * Roles
         */
        $master = $rolePermission->createRole('super.user.master');
        $senior = $rolePermission->createRole('super.user.senior');
        $junior = $rolePermission->createRole('super.user.junior');

        /**
         * Permissions
         */

        /**
         * assign user roles 
        */
        $rolePermission->createPermission('user.role.permission.index')->syncRoles([$master, $senior]);
        $rolePermission->createPermission('user.role.permission.create')->syncRoles([$master, $senior]);
        $rolePermission->createPermission('user.role.permission.update')->syncRoles([$master, $senior]);
        $rolePermission->createPermission('user.role.permission.delete')->syncRoles([$master]);

        /**
         * user administrator
         */
        $rolePermission->createPermission('user.administrator.index')->syncRoles([$master, $senior]);
        $rolePermission->createPermission('user.administrator.create')->syncRoles([$master, $senior]);
        $rolePermission->createPermission('user.administrator.update')->syncRoles([$master, $senior]);
        $rolePermission->createPermission('user.administrator.delete')->syncRoles([$master]);
    }
}
