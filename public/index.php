<?php

require_once __DIR__ . '/../vendor/autoload.php';

try {
    // Configure the injector
    $injector = new \Auryn\Injector();

    // Configure the router
    $routerContainer = new \Aura\Router\RouterContainer();
    $routerMap       = $routerContainer->getMap();

    $routerMap->get('graphiql', '/', \Jalle19\Tlk\SongBook\Http\Handlers\GraphiQLHandler::class);
    $routerMap->post('graphql', '/graphql', \Jalle19\Tlk\SongBook\Http\Handlers\GraphQLHandler::class);

    $matcher = $routerContainer->getMatcher();
    $request = \Zend\Diactoros\ServerRequestFactory::fromGlobals();

    $route = $matcher->match($request);

    if ($route === false) {
        throw new \Aura\Router\Exception\RouteNotFound('Route not found');
    }

    $handlerClass = $route->handler;

    /** @var \Psr\Http\Server\RequestHandlerInterface $handler */
    $handler = $injector->make($handlerClass);

    if (!($handler instanceof \Psr\Http\Server\RequestHandlerInterface)) {
        throw new \RuntimeException('All request handlers must implement ' . \Psr\Http\Server\RequestHandlerInterface::class);
    }

    $response = $handler->handle($request);


} catch (\Throwable $e) {
    $response = new \Zend\Diactoros\Response\JsonResponse([
        'type'    => get_class($e),
        'message' => $e->getMessage(),
        'trace'   => $e->getTrace(),
    ], 500);
}

$emitter = new \Zend\HttpHandlerRunner\Emitter\SapiEmitter();
$emitter->emit($response);
