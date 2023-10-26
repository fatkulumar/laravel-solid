<?php

    namespace App\DataTransferObject;

    use App\DataTransferObject\GenericDTO;

    class UserDTO extends GenericDTO
    {
        private $id,
                $name,
                $email,
                $password,
                $role,
                $permission,
                $guardName,
                $modelId;

        public function getId()
        {
            return $this->id;
        }

        public function setId($id)
        {
            return $this->id = $id;
        }

        public function getName()
        {
            return $this->name;
        }

        public function setName($name)
        {
            return $this->name = $name;
        }

        public function getEmail()
        {
            return $this->email;
        }

        public function setEmail($email)
        {
            return $this->email = $email;
        }

        public function getPassword()
        {
            return $this->password;
        }

        public function setPassword($password)
        {
            return $this->password = $password;
        }

        public function getRole()
        {
            return $this->role;
        }

        public function setRole($role)
        {
            return $this->role = $role;
        }

        public function getPermission()
        {
            return $this->permission;
        }

        public function setPermission($permission)
        {
            return $this->permission = $permission;
        }

        public function getGuardName()
        {
            return $this->guardName;
        }

        public function setGuardName($guardName)
        {
            return $this->guardName = $guardName;
        }

        public function getModelId()
        {
            return $this->modelId;
        }

        public function setModelId($modelId)
        {
            return $this->modelId = $modelId;
        }
    }

