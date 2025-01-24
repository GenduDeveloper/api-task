<?php

namespace App\Http\Requests\Users;

use App\DTO\Users\UserRegisterDTO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'min:2'],
            'last_name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string',
                Password::min(8)
                    ->letters()
                    ->letters()
            ],
            'password_repeat' => ['required', 'string', 'min:8', 'same:password']
        ];
    }

    public function getDTO(): UserRegisterDTO
    {
        return new UserRegisterDTO(
            $this->get('first_name'),
            $this->get('last_name'),
            $this->get('email'),
            $this->get('password'),
        );
    }
}
