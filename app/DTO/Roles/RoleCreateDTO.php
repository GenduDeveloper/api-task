<?php

namespace App\DTO\Roles;

class RoleCreateDTO
{
    public function __construct(public readonly string $role)
    {
    }

    public function getRole(): string
    {
        return $this->role;
    }
}
