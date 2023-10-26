<?php

    namespace App\Repositories\SuperAdmin\Permission;

    use App\Models\ModelHasPermission;
    use App\Repositories\Eloquent;
    use App\Repositories\SuperAdmin\Permission\HasPermissionSuperAdminRepository;

    class HasPermissionSuperAdminRepositoryImplement extends Eloquent implements HasPermissionSuperAdminRepository
    {
        protected $model;

        public function __construct(ModelHasPermission $model)
        {
            $this->model = $model;
        }

        public function updatePermission($modelId, array $data): array
        {
            $this->model->where('model_id', $modelId)->update($data);
            return $data;
        }

        public function deletePermission($modelId): bool
        {
            $data = $this->model->where('model_id', $modelId)->delete();
            return $data;
        }

        public function getPermissionByModelId($modelId)
        {
            $data = $this->model->where('model_id', $modelId)->get();
            return $data;
        }
    }
