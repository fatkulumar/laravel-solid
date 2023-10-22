<?php

    namespace App\Services\ForgotPassword;

    use App\DataTransferObject\UserDTO;
    use Illuminate\Http\JsonResponse;

    interface ForgotPasswordService
    {
        public function forgotPassword(UserDTO $params): JsonResponse;
    }

