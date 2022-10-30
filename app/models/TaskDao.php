<?php 

    namespace App\Models;

    class TaskDao{

        private $connection;
        private $task;

        public function __construct($connection, Task $task){

            $this->connection = $connection->getDb();
            $this->task = $task;
        }

        public function insertTask(){
            $query = "insert into tasks (description) values (:description)";
            $stmt = $this->connection->prepare($query);
            $stmt->bindValue(':description', $this->task->__get('description'));
            return $stmt->execute();
        }

        public function updateTask(){
            $query = "update tasks set description = :description where id = :id";
            $stmt = $this->connection->prepare($query);
            $stmt->bindValue(':description', $this->task->__get('description'));
            $stmt->bindValue(':id', $this->task->__get('id'));
            return $stmt->execute();
        }

        public function getTasks(){
            $query = "select * from tasks order by id desc";
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function deleteTask(){
            $query = "delete from tasks where id = :id";
            $stmt = $this->connection->prepare($query);
            $stmt->bindValue(':id', $this->task->__get('id'));
            return $stmt->execute();
        }
    }

?>