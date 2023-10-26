<?php

    namespace App\Repositories\SuperAdmin\Role;

    use App\Models\ModelHasRole;
    use App\Repositories\Eloquent;
    use App\Repositories\SuperAdmin\Role\HasRoleSuperAdminRepository;

    class HasRoleSuperAdminRepositoryImplement extends Eloquent implements HasRoleSuperAdminRepository
    {
        protected $model;

        public function __construct(ModelHasRole $model)
        {
            $this->model = $model;
        }

        public function updateRole($roleId, array $data): array
        {
            $this->model->where('model_id', $roleId)->update($data);
            return $data;
        }

        public function deleteRole($modelId): bool
        {
            $data = $this->model->where('model_id', $modelId)->delete();
            return $data;
        }

        public function getRoleByModelId($modelId)
        {
            $data = $this->model->where('model_id', $modelId)->get();
            return $data;
        }
    }
