<?php

    namespace App\Repositories\Auth;

    use App\Models\User;
    use App\Repositories\Eloquent;
    use App\Repositories\Auth\AuthRepository;

    class AuthRepositoryImplement extends Eloquent implements AuthRepository
    {
        protected $model;

        public function __construct(User $model)
        {
            $this->model = $model;
        }

        public function getByIdUser($id)
        {
            $data = $this->model::find($id);
            return $data;
        }
    }
