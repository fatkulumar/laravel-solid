<?php

    namespace App\Services\SuperAdmin\User;

    use App\DataTransferObject\UserDTO;
    use Illuminate\Http\JsonResponse;

    interface UserSuperAdminService
    {
        public function users(): JsonResponse;
        public function updateUser(UserDTO $params): JsonResponse;
    }
