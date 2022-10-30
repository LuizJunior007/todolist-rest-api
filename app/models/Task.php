<?php 

    namespace App\Models;

    class Task{

        private int $id;
        private string $description;
        private bool $isCompleted;

        public function __set($atr, $val){
            $this->$atr = $val;
        }

        public function __get($atr){
            return $this->$atr;
        }
    }
?>