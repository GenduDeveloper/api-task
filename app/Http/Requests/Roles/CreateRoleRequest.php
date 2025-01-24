<?php

namespace App\Http\Requests\Roles;

use App\DTO\Roles\RoleCreateDTO;
use Illuminate\Foundation\Http\FormRequest;

class CreateRoleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'role' => ['required', 'string']
        ];
    }

    public function getDTO(): RoleCreateDTO
    {
        return new RoleCreateDTO($this->get('role'));
    }
}
