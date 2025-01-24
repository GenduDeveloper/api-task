<?php

namespace App\Repositories;

use App\Exceptions\UserNotFoundException;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository
{
    private const PER_PAGE = 5;

    /**
     * @throws UserNotFoundException
     */
    public function getPaginated(): LengthAwarePaginator
    {
        $users = User::query()
            ->select(['id', 'first_name', 'last_name', 'email', 'role_id'])
            ->paginate(self::PER_PAGE);

        if ($users->isEmpty()) {
            throw new UserNotFoundException('Пользователей не существует');
        }

        return $users;
    }

    /**
     * @throws UserNotFoundException
     */
    public function getById(int $id): ?User
    {
        $user = User::find($id);

        if ($user === null) {
            throw new UserNotFoundException('Такого пользователя не существует');
        }

        return $user;
    }

}
