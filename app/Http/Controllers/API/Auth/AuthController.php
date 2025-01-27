<?php

namespace App\Http\Controllers\API\Auth;

use App\Exceptions\RegisterErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\LoginUserRequest;
use App\Http\Requests\Users\RegisterUserRequest;
use App\Http\Resources\Users\UserResource;
use App\Services\Auth\AuthService;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    /**
     * @throws RegisterErrorException
     */
    public function register(RegisterUserRequest $request, AuthService $authService): JsonResponse
    {
        $validatedData = $request->getDTO();

        $createdUser = $authService->registerUser($validatedData);

        return response()->json([
            'message' => 'Пользователь был успешно создан',
            'user' => new UserResource($createdUser),
        ], 201);
    }

    /**
     * @throws AuthenticationException
     */
    public function login(LoginUserRequest $request, AuthService $authService): JsonResponse
    {
        $validatedData = $request->getDTO();
        $authService->loginUser($validatedData);

        $token = \Auth::user()->createToken('api')->plainTextToken;

        return response()->json([
            'message' => 'Вы успешно вошли',
            'token' => $token,
        ]);
    }

    public function logout(): JsonResponse
    {
        $user = \Auth::user();

        $user->tokens()->delete();

        return response()->json([
            'message' => 'Вы успешно вышли'
        ]);
    }
}
