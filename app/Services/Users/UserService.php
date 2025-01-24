<?php

namespace App\Services\Users;

use App\DTO\Users\UserRegisterDTO;
use App\DTO\Users\UserUpdateDTO;
use App\Exceptions\RegisterErrorException;
use App\Exceptions\UserNotFoundException;
use App\Models\Role;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    /**
     * @throws RegisterErrorException
     */
    public function registerUser(UserRegisterDTO $dtoData): ?User
    {
        $user = new User();

        $user->first_name = $dtoData->getFirstName();
        $user->last_name = $dtoData->getLastName();
        $user->email = $dtoData->getEmail();
        $user->password = Hash::make($dtoData->getPassword());
        $user->role_id = Role::USER_ROLE_ID;

        if (!$user->save()) {
            throw new RegisterErrorException('Произошла ошибка при регистрации. Попробуйте еще раз.');
        }

        return $user;
    }

    /**
     * @throws UserNotFoundException
     */
    public function updateUser(int $id, UserUpdateDTO $dtoData): ?User
    {
        $user = $this->userRepository->getById($id);

        if ($dtoData->firstName !== null) {
            $user->first_name = $dtoData->firstName;
        }

        if ($dtoData->lastName !== null) {
            $user->last_name = $dtoData->lastName;
        }

        if ($dtoData->email !== null) {
            $user->email = $dtoData->email;
        }

        $user->update();

        return $user;
    }
}
