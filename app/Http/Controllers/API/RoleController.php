<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Roles\CreateRoleRequest;
use App\Http\Resources\Roles\RoleResource;
use App\Repositories\RoleRepository;
use App\Services\RoleService;
use Illuminate\Http\JsonResponse;

class RoleController extends Controller
{
    public function index(RoleRepository $roleRepository): JsonResponse
    {
        return response()->json([
            'roles' => RoleResource::collection($roleRepository->findAll())
        ]);
    }

    public function create(CreateRoleRequest $request, RoleService $roleService)
    {
        $validatedData = $request->getDTO();

        $roleService->create($validatedData);

        return response()->json([
            'message' => 'Новая роль успешно добавлена',
        ]);
    }
}
