<?php

namespace App\Services;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Services\Interface\ServiceInterface;

class RolePermissionService implements ServiceInterface
{
    public function validate(array $rules): self
    {
        return $this;
    }

    public function createPermission(string $name)
    {
        return Permission::create(['guard_name' => 'web', 'name' => $name]);
    }

    public function createRole(string $name)
    {
        return Role::create(['guard_name' => 'web', 'name' => $name]);
    }
}
