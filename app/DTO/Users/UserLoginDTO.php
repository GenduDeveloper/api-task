<?php

namespace App\DTO\Users;

class UserLoginDTO
{
    public function __construct(
        private readonly string $email,
        private readonly string $password,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'email' => $this->email,
            'password' => $this->password
        ];
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
