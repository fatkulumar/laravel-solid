<?php

    namespace App\Repositories\SuperAdmin\Permission;

    interface HasPermissionSuperAdminRepository
    {
        public function updatePermission($modelId, array $data): array;
        public function deletePermission($modelId): bool;
        public function getPermissionByModelId($modelId);
    }
