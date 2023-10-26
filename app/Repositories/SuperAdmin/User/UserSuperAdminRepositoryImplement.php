<?php

    namespace App\Repositories\SuperAdmin\User;

    use App\Models\ModelUser;
    use App\Repositories\Eloquent;
    use App\Repositories\SuperAdmin\User\UserSuperAdminRepository;

    class UserSuperAdminRepositoryImplement extends Eloquent implements UserSuperAdminRepository
    {
        protected $model;

        public function __construct(ModelUser $model)
        {
            $this->model = $model;
        }

        public function users(): object
        {
            $data = $this->model->with('roles:role_id,model_id', 'permissions:permission_id,model_id')
                                ->select('users.id', 'users.name', 'users.email')
                                ->get();
            return $data;
        }

        public function userByEmail($email): object
        {
            $data = $this->model->with('roles:role_id,model_id', 'permissions:permission_id,model_id')
                                ->where('users.email', $email)
                                ->select('users.id', 'users.name', 'users.email')
                                ->get();
            return $data;
        }
    }
