<?php 

    namespace App\Middlewares;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
    use Slim\Psr7\Response;

    class MiddlewareExample{

        public function validate(Request $request, RequestHandler $handler){

            $response = $handler->handle($request);
            $content = (string) $response->getBody();

            $response = new Response();
            $response->getBody()->write('Autenticado' . $content);

            return $response;
        }
    }

?>