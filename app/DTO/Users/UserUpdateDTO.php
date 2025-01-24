<?php

namespace App\DTO\Users;

class UserUpdateDTO
{
    // чтобы не писать огромный класс с геттерами, мы можем свойства объявить как readonly и сделать их публичными
    public function __construct(
        public readonly ?string $firstName,
        public readonly ?string $lastName,
        public readonly ?string $email,
    )
    {
    }
}
