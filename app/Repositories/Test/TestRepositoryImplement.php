<?php

    namespace App\Repositories\Test;

    use App\Models\Test;
    use App\Repositories\Eloquent;
    use App\Repositories\Test\TestRepository;

    class TestRepositoryImplement extends Eloquent implements TestRepository
    {
        protected $model;

        public function __construct(Test $model)
        {
            $data = $this->model = $model;
        }
    }
