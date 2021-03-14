<?php

use App\Http\Action\AboutAction;
use App\Http\Action\Blog\IndexAction;
use App\Http\Action\Blog\ShowAction;
use App\Http\Action\CabinetAction;
use App\Http\Action\HelloAction;
use App\Http\Middleware\BasicAuthMiddleware;
use App\Http\Middleware\NotFoundHandler;
use App\Http\Middleware\ProfileMiddleware;
use Aura\Router\RouterContainer;
use Framework\Http\MiddlewareResolver;
use Framework\Http\Router\AuraRouterAdapter;
use Framework\Http\Router\Exception\RequestNotMatchedException;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\ServerRequestFactory;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;
use Framework\Http\Pipeline\Pipeline;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';
require 'helpers.php';

$params = ['users' => ['admin' => 'password']];

### Initialization

session_start();
$request = ServerRequestFactory::fromGlobals();

### Router
$aura   = new RouterContainer();
$routes = $aura->getMap();

$routes->get('home', '/', HelloAction::class);

$routes->get(
    'cabinet',
    '/cabinet',
    [
        new BasicAuthMiddleware($params['users']),
        CabinetAction::class,
    ]);

$routes->get('about', '/about', AboutAction::class);
$routes->get('blog', '/blog', IndexAction::class);
$routes->get('blog_show', '/blog/{id}', ShowAction::class)->tokens(['id' => '\d+']);

$router   = new AuraRouterAdapter($aura);
$resolver = new MiddlewareResolver();

$pipeline = new Pipeline();
$pipeline->pipe($resolver->resolve(ProfileMiddleware::class));

### PreProcessing

### Running
$request = ServerRequestFactory::fromGlobals();
try {
    $route = $router->match($request);
    //добавляем все атрибуты из роута в реквест
    foreach ($route->getAttributes() as $attribute => $value) {
        $request = $request->withAttribute($attribute, $value);
    }

    ### Action
    $handler = $route->getHandler();
    $middleware = $resolver->resolve($handler);
    $pipeline->pipe($middleware);
} catch (RequestNotMatchedException $e) {
}

$response = $pipeline($request, new NotFoundHandler());

### PostProcessing

/** @var HtmlResponse $response */
$response = $response->withHeader('X-Developer', 'eagle');

### Sending

$emitter = new SapiEmitter();
$emitter->emit($response);