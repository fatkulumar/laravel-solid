<?php

    namespace App\DataTransferObject;

    use App\DataTransferObject\GenericDTO;

    class TestDTO extends GenericDTO
    {
        private $id,
                $test,
                $file;

        public function getId()
        {
            return $this->id;
        }

        public function setId($id)
        {
            return $this->id = $id;
        }

        public function getTest()
        {
            return $this->test;
        }

        public function setTest($test)
        {
            return $this->test = $test;
        }

        public function getFile()
        {
            return $this->file;
        }

        public function setFile($file)
        {
            return $this->file = $file;
        }
    }

