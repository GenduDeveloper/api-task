<?php

namespace App\Services\Roles;

use App\DTO\Roles\RoleCreateDTO;
use App\Models\Role;

class RoleService
{
    public function create(RoleCreateDTO $dtoData): Role
    {
        $role = new Role();

        $role->role = $dtoData->role;
        $role->save();

        return $role;
    }
}
