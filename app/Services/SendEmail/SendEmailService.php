<?php

    namespace App\Services\SendEmail;

    use App\DataTransferObject\UserDTO;
    use Illuminate\Http\JsonResponse;

    interface SendEmailService
    {
        public function sendEmail(UserDTO $params): JsonResponse;
    }

