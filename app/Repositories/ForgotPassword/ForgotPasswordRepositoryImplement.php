<?php

    namespace App\Repositories\ForgotPassword;

    use App\Models\User;
    use App\Repositories\Eloquent;
    use App\Repositories\ForgotPassword\ForgotPasswordRepository;

    class ForgotPasswordRepositoryImplement extends Eloquent implements ForgotPasswordRepository
    {
        protected $model;

        public function __construct(User $model)
        {
            $this->model = $model;
        }
    }
