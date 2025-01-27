<?php

namespace App\Services\Auth;

use App\DTO\Users\UserLoginDTO;
use App\DTO\Users\UserRegisterDTO;
use App\Exceptions\RegisterErrorException;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
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
     * @throws AuthenticationException
     */
    public function loginUser(UserLoginDTO $dtoData): bool
    {
        $credentials = $dtoData->toArray();

        if (!Auth::attempt($credentials)) {
            throw new AuthenticationException('Логин или пароль неверны. Попробуйте еще раз.');
        }

        return true;
    }
}
