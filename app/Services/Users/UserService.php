<?php

namespace App\Services\Users;

use App\DTO\Users\UserUpdateDTO;
use App\Exceptions\UserNotFoundException;
use App\Models\User;
use App\Repositories\UserRepository;

class UserService
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    /**
     * @throws UserNotFoundException
     */
    public function updateUser(int $id, UserUpdateDTO $dtoData): ?User
    {
        $user = $this->userRepository->getById($id);

        if ($dtoData->getFirstName() !== null) {
            $user->first_name = $dtoData->getFirstName();
        }

        if ($dtoData->getLastName() !== null) {
            $user->last_name = $dtoData->getLastName();
        }

        if ($dtoData->getEmail() !== null) {
            $user->email = $dtoData->getEmail();
        }

        $user->update();
        return $user;
    }
}
