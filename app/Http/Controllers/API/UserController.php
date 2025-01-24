<?php

namespace App\Http\Controllers\API;

use App\Exceptions\RegisterErrorException;
use App\Exceptions\UserNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\RegisterUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Http\Resources\Users\UserResource;
use App\Repositories\UserRepository;
use App\Services\Users\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * @throws UserNotFoundException
     */
    public function index(UserRepository $userRepository): JsonResponse
    {
        $paginatedUsers = $userRepository->getPaginated();

        return response()->json([
            'users' => UserResource::collection($paginatedUsers),
            'current_page' => $paginatedUsers->currentPage(),
            'last_page' => $paginatedUsers->lastPage()
        ]);
    }

    /**
     * @throws UserNotFoundException
     */
    public function show(int $id, UserRepository $userRepository): JsonResponse
    {
        $user = $userRepository->getById($id);

        return response()->json([
            'user' => new UserResource($user),
        ]);
    }

    /**
     * @throws UserNotFoundException
     */
    public function update(int $id, UpdateUserRequest $request, UserService $userService): JsonResponse
    {
        $validatedData = $request->getDTO();

        $updatedUser = $userService->updateUser($id, $validatedData);

        return response()->json([
            'message' => 'Успешно обновлено',
            'user' => new UserResource($updatedUser)
        ]);
    }

    /**
     * @throws RegisterErrorException
     */
    public function register(RegisterUserRequest $request, UserService $userService): JsonResponse
    {
        $validatedData = $request->getDTO();

        $createdUser = $userService->registerUser($validatedData);

        return response()->json([
            'message' => 'Пользователь был успешно создан',
            'user' => new UserResource($createdUser)
        ], 201);
    }

    /**
     * @throws UserNotFoundException
     */
    public function destroy(int $id, UserRepository $userRepository): JsonResponse
    {
        $user = $userRepository->getById($id);

        $user->delete();

        return response()->json([
            'message' => "Пользователь {$user->getFullName()} был успешно удален",
        ], 204);
    }
}
