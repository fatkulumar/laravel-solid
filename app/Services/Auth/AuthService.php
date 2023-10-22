<?php

    namespace App\Services\Auth;

    use App\DataTransferObject\UserDTO;
    use Illuminate\Http\JsonResponse;

    interface AuthService
    {
        public function register(UserDTO $params): JsonResponse;
        public function login(UserDTO $params): JsonResponse;
        public function logout(UserDTO $params): JsonResponse;
        public function notAuthorized(): JsonResponse;
    }

