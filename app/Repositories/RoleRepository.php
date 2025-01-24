<?php

namespace App\Repositories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RoleRepository
{
    public function findAll(): Collection
    {
        $roles = Role::select(['id', 'role'])
            ->orderBy('role')
            ->get();

        if ($roles->isEmpty()) {
            throw new ModelNotFoundException('Нет ни одной роли');
        }

        return $roles;
    }
}
