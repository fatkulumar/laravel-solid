<?php

    namespace App\Services\Test;

    use App\DataTransferObject\TestDTO;
    use Illuminate\Http\JsonResponse;

    interface TestService
    {
        public function all(): JsonResponse;
        public function getById(TestDTO $params): JsonResponse;
        public function create(TestDTO $params): JsonResponse;
        public function update(TestDTO $params): JsonResponse;
        public function delete(TestDTO $params): JsonResponse;
        public function destroy(TestDTO $params): JsonResponse;
    }
