<?php 

    use Slim\Factory\AppFactory;
    use App\Controllers\TaskController;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Log\LoggerInterface;

    $app = AppFactory::create();
    $app->addBodyParsingMiddleware();

    $app->options('/{routes:.+}', function ($request, $response, $args) {
        return $response;
    });
    
    $app->add(function ($request, $handler) {
        $response = $handler->handle($request);
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('Access-Control-Allow-Origin', 'http://mysite')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
    });

    $customErrorHandler = function (Request $request, Throwable $exception, bool $displayErrorDetails, bool $logErrors, bool $logErrorDetails, ?LoggerInterface $logger = null) use ($app) {
        $logger?->error($exception->getMessage());
        $response = $app->getResponseFactory()->createResponse();
        $code = $exception->getCode();

        if ($code === 404) {
            $payload = "<h1>404 - Página não encontrada!</h1>";
            $response->getBody()->write(json_encode($payload));
        } else {
            $payload = "Erro desconhecido.";
            $response->getBody()->write(json_encode($payload));
        }
            return $response;
        };

    $errorMiddleware = $app->addErrorMiddleware(true, true, true);
    $errorMiddleware->setDefaultErrorHandler($customErrorHandler);
    
    $app->post('/task', TaskController::class . ':newTask');
    $app->get('/tasks', TaskController::class . ':getAllTasks');
    $app->put('/task/{id}', TaskController::class . ':updateMyTask');
    $app->delete('/task/{id}', TaskController::class . ':deleteMyTask');
    $app->run();
?>