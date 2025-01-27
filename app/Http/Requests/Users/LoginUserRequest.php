<?php

namespace App\Http\Requests\Users;

use App\DTO\Users\UserLoginDTO;
use Illuminate\Foundation\Http\FormRequest;

class LoginUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    public function getDTO(): UserLoginDTO
    {
        return new UserLoginDTO(
            $this->get('email'),
            $this->get('password'),
        );
    }
}
