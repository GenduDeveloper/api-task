<?php

namespace App\DTO\Users;

class UserUpdateDTO
{
    public function __construct(
        private readonly ?string $firstName,
        private readonly ?string $lastName,
        private readonly ?string $email,
    )
    {
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }
}
