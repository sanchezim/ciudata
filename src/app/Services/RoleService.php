<?php

namespace App\Services;

use App\Http\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use App\Http\Traits\ServiceTrait;
use Spatie\Permission\Models\Role;
use App\Services\Interface\ServiceInterface;

class RoleService implements ServiceInterface
{
    use ApiResponseTrait, ServiceTrait;

    protected Role $role;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->message = __('Request accepted');
    }

    public function validate(array $rules): self
    {
        $this->request->validate($rules);
        return $this;
    }

    public function givePermission(): self
    {
        foreach ($this->request->permissions as $permission) {
            $this->role->givePermissionTo($permission);
        }
        return $this;
    }

    public function revokePermissions()
    {
        foreach ($this->request->permissions as $permission) {
            $this->role->revokePermissionTo($permission);
        }
        return $this;
    }

    /**
     * Set the value of role
     *
     * @return  self
     */ 
    public function setRole($role): self
    {
        $this->role = $role;

        return $this;
    }

    public function assignPermissionsResponse()
    {
        return $this->serviceResponse([
            'code'      => $this->code,
            'message'   => $this->message,
        ]);
    }

    public function revokePermissionsResponse()
    {
        return $this->serviceResponse([
            'code'      => $this->code,
            'message'   => $this->message,
        ]);
    }
}
