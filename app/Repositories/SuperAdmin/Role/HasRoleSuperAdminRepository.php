<?php

    namespace App\Repositories\SuperAdmin\Role;

    interface HasRoleSuperAdminRepository
    {
        public function updateRole($modelId, array $data): array;
        public function deleteRole($modelId): bool;
        public function getRoleByModelId($modelId);
    }
