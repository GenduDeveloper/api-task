<?php

namespace App\Http\Requests\Users;

use App\DTO\Users\UserUpdateDTO;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => ['nullable', 'string', 'min:2'],
            'last_name' => ['nullable', 'string'],
            'email' => ['nullable', 'email', 'unique:users,email'],
        ];
    }

    public function getDTO(): UserUpdateDTO
    {
        return new UserUpdateDTO(
            $this->get('first_name'),
            $this->get('last_name'),
            $this->get('email')
        );
    }
}
