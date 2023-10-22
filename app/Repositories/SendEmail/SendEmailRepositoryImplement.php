<?php

    namespace App\Repositories\SendEmail;

    use App\Models\User;
    use App\Repositories\Eloquent;
    use App\Repositories\SendEmail\SendEmailRepository;

    class SendEmailRepositoryImplement extends Eloquent implements SendEmailRepository
    {
        protected $model;

        public function __construct(User $model)
        {
            $this->model = $model;
        }
    }
