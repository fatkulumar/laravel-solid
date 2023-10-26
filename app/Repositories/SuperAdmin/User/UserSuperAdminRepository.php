<?php

    namespace App\Repositories\SuperAdmin\User;

    interface UserSuperAdminRepository
    {
        public function users(): object | null;
        public function userByEmail($email): object;
    }
