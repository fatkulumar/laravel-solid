<?php

    namespace App\Repositories;


    interface Repository
    {
        public function all(): object;
        public function getById($id): object;
        public function create($data): object;
        public function update($id, array $data): array;
        public function delete($id): bool;
        public function destroy(array $id): string;
        public function getByEmail($email): object | null;
    }
