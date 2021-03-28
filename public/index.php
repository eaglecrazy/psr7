<?php

use App\Http\Action\AboutAction;
use App\Http\Action\Blog\IndexAction;
use App\Http\Action\Blog\ShowAction;
use App\Http\Action\CabinetAction;
use App\Http\Action\HelloAction;
use App\Http\Middleware\BasicAuthMiddleware;
use App\Http\Middleware\CredentialsMiddleware;
use App\Http\Middleware\NotFoundHandler;
use App\Http\Middleware\ProfilerMiddleware;
use Aura\Router\RouterContainer;
use Framework\Application;
use Framework\Container\Container;
use Framework\Http\MiddlewareResolver;
use Framework\Http\Router\AuraRouterAdapter;
use Framework\Http\Router\Router;
use Framework\Middleware\DispatchMiddleware;
use Framework\Middleware\RouteMiddleware;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequestFactory;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

### Configuration
$container = new Container();
//$container->set('config', require('config/params.php'));
$container->set('config', [
    'debug'    => true,
    'users'    => ['admin' => 'password'],
    'per_page' => 10,
    'address'  => 'ya@mail.ru',
    'db'       => [
        'dsn'      => 'mysql:localhost;dbname=courson',
        'username' => 'homestead',
        'password' => 'secret',
    ],
    'mailer'   => [
        'username' => 'root',
        'password' => 'secret',
    ],
]);

$container->set(Application::class, function (Container $container) {
    return new Application(
        $container->get(MiddlewareResolver::class),
        $container->get(Router::class),
        new NotFoundHandler(),
        new Response());
});

$container->set(BasicAuthMiddleware::class, function (Container $container) {
    return new BasicAuthMiddleware($container->get('config')['users'], new Response());
});

$container->set(MiddlewareResolver::class, function (){
    return new MiddlewareResolver();
});

$container->set(RouteMiddleware::class, function (Container $container){
    return new RouteMiddleware($container->get(Router::class));
});

$container->set(DispatchMiddleware::class, function (Container $container){
    return new DispatchMiddleware($container->get(MiddlewareResolver::class));
});

$container->set(Router::class, function (){
    $aura = new RouterContainer();
    return new AuraRouterAdapter($aura);
});

### Initialization

session_start();
$request = ServerRequestFactory::fromGlobals();


### App

/** @var Application $app */
$app = $container->get(Application::class);

//$app->pipe(new ErrorHandlerMiddleware($params['debug']));
$app->pipe(CredentialsMiddleware::class);
$app->pipe(ProfilerMiddleware::class);
$app->pipe($container->get(RouteMiddleware::class));
$app->pipe('cabinet', $container->get(BasicAuthMiddleware::class));
$app->pipe($container->get(DispatchMiddleware::class));


### Routes
$app->get('home', '/', HelloAction::class);
$app->get('about', '/about', AboutAction::class);
$app->get('blog', '/blog', IndexAction::class);
$app->get('blog_show', '/blog/{id}', ShowAction::class, ['tokens' => ['id' => '\d+']]);
$app->get('cabinet', '/cabinet', CabinetAction::class);

### Running
$response = $app->run($request, new Response());

### Sending
$emitter = new SapiEmitter();
$emitter->emit($response);