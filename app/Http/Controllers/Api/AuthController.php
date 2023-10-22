<?php

namespace App\Http\Controllers\Api;

use App\DataTransferObject\UserDTO;
use App\Http\Controllers\Controller;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $authService;

    function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    /**
     * Create User.
     */
    public function register(Request $request)
    {
        $userDTO = new UserDTO;
        $userDTO->setName($request->post('name'));
        $userDTO->setEmail($request->post('email'));
        $userDTO->setPassword($request->post('password'));
        $result = $this->authService->register($userDTO);
        return $result;
    }

    public function login(Request $request)
    {
        $userDTO = new UserDTO;
        $userDTO->setEmail($request->post('email'));
        $userDTO->setPassword($request->post('password'));
        $result = $this->authService->login($userDTO);
        return $result;
    }

    public function logout(Request $request)
    {
        $userDTO = new UserDTO;
        $userDTO->setToken($request->bearerToken());
        $result = $this->authService->logout($userDTO);
        return $result;
    }

    public function notAuthorized()
    {
        $result = $this->authService->notAuthorized();
        return $result;
    }
}
