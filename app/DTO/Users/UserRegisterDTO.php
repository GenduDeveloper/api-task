<?php

namespace App\DTO\Users;

class UserRegisterDTO
{
    public function __construct(
        private readonly string $firstName,
        private readonly string $lastName,
        private readonly string $email,
        private readonly string $password,
    )
    {
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
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
