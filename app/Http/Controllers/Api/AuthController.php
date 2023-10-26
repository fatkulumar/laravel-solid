<?php

namespace App\Http\Controllers\Api;

use App\DataTransferObject\UserDTO;
use App\Http\Controllers\Controller;
use App\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $authService;

    function __construct(AuthService $authService)
    {
        $this->authService = $authService;

        // $this->middleware(['role:super admin'])->only(['logout']);
    }
    /**
     * Create User.
     */
    public function register(Request $request): JsonResponse
    {
        $userDTO = new UserDTO;
        $userDTO->setName($request->post('name'));
        $userDTO->setEmail($request->post('email'));
        $userDTO->setPassword($request->post('password'));
        $userDTO->setRole($request->post('role'));
        $userDTO->setPermission($request->post('permission'));
        $userDTO->setGuardName($request->post('guard_name'));
        $result = $this->authService->register($userDTO);
        return $result;
    }

    public function login(Request $request): JsonResponse
    {
        $userDTO = new UserDTO;
        $userDTO->setEmail($request->post('email'));
        $userDTO->setPassword($request->post('password'));
        $result = $this->authService->login($userDTO);
        return $result;
    }

    public function logout(Request $request): JsonResponse
    {
        $userDTO = new UserDTO;
        $userDTO->setToken($request->bearerToken());
        $result = $this->authService->logout($userDTO);
        return $result;
    }

    public function notAuthorized(): JsonResponse
    {
        $result = $this->authService->notAuthorized();
        return $result;
    }
}
