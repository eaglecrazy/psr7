<?php
закончил 1-18
use App\Http\Action\AboutAction;
use App\Http\Action\Blog\IndexAction;
use App\Http\Action\Blog\ShowAction;
use App\Http\Action\CabinetAction;
use App\Http\Action\HelloAction;
use App\Http\Middleware\BasicAuthMiddleware;
use App\Http\Middleware\CredentialsMiddleware;
use App\Http\Middleware\NotFoundHandler;
use App\Http\Middleware\ProfileMiddleware;
use Aura\Router\RouterContainer;
use Framework\Application;
use Framework\Container\Container;
use Framework\Http\MiddlewareResolver;
use Framework\Http\Router\AuraRouterAdapter;
use Framework\Middleware\DispatchMiddleware;
use Framework\Middleware\RouteMiddleware;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequestFactory;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

### Configuration
$container = new Container();
$container->set('debug', true);
$container->set('users', ['admin' => 'password'],);

### Initialization

session_start();
$request = ServerRequestFactory::fromGlobals();

### Router
$aura   = new RouterContainer();
$router   = new AuraRouterAdapter($aura);
$routes = $aura->getMap();
### Routes
$routes->get('home', '/', HelloAction::class);
$routes->get('about', '/about', AboutAction::class);
$routes->get('blog', '/blog', IndexAction::class);
$routes->get('blog_show', '/blog/{id}', ShowAction::class)->tokens(['id' => '\d+']);
$routes->get('cabinet', '/cabinet', CabinetAction::class);

### App
$resolver = new MiddlewareResolver();
$app      = new Application($resolver, new NotFoundHandler(), new Response());


//$app->pipe(new ErrorHandlerMiddleware($params['debug']));
$app->pipe(CredentialsMiddleware::class);
$app->pipe(ProfileMiddleware::class);
$app->pipe('/cabinet', new BasicAuthMiddleware($container->get('users'), new Response()));
$app->pipe(new RouteMiddleware($router));
$app->pipe(new DispatchMiddleware($resolver));

### Running
$response = $app->run($request, new Response());

### Sending
$emitter = new SapiEmitter();
$emitter->emit($response);