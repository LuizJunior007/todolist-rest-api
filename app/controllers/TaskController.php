<?php 

    namespace App\Controllers;
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use App\Models\Task;
    use App\Models\TaskDao;
    use App\Connection;

    class TaskController{

        public function getAllTasks(Request $request, Response $response, array $args){

            $conn = new Connection();
            $task = new Task;
            $taskDao = new TaskDao($conn, $task);
            
            $response->getBody()->write(json_encode($taskDao->getTasks()));
            
            return $response;
        }

        public function newTask(Request $request, Response $response, array $args){

            $data = (array)$request->getParsedBody();

            $conn = new Connection();
            $task = new Task;
            $taskDao = new TaskDao($conn, $task);

            $task->__set('description', $data['description']);

            if($taskDao->insertTask()){

                $response->getBody()->write(json_encode(true));
            } else{

                $response->getBody()->write(json_encode('Ocorreu um erro, verifique se os dados foram preenchidos corretamente'));
            }

            return $response;
        }

        public function updateMyTask(Request $request, Response $response, array $args){

            $data = $request->getParsedBody();
            
            $conn = new Connection();
            $task = new Task();
            $taskDao = new TaskDao($conn, $task);

            $task->__set('description', $data['description']);
            $task->__set('id', $args['id']);

            if($taskDao->updateTask()){

                $response->getBody()->write(json_encode(true));
            } else{

                $response->getBody()->write(json_encode('Ocorreu um erro, verifique se os dados foram preenchidos corretamente!'));
            }

            return $response;
        }

        public function deleteMyTask(Request $request, Response $response, array $args){

            $conn = new Connection();
            $task = new Task();
            $taskDao = new TaskDao($conn, $task);

            $task->__set('id', $args['id']);

            if($taskDao->deleteTask()){

                $response->getBody()->write(json_encode(true));
            } else{

                $response->getBody()->write(json_encode('Ocorreu um erro, verifique se os dados foram preenchidos corretamente!'));
            }

            return $response;
        }
    }
?>