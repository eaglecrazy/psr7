<?php

use App\Http\Action\AboutAction;
use App\Http\Action\Blog\IndexAction;
use App\Http\Action\Blog\ShowAction;
use App\Http\Action\HelloAction;
use Aura\Router\RouterContainer;
use Framework\Http\ActionResolver;
use Framework\Http\Router\Exception\RequestNotMatchedException;
use Framework\Http\Router\AuraRouterAdapter;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\ServerRequestFactory;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';
require 'helpers.php';

### Initialization

session_start();
$request = ServerRequestFactory::fromGlobals();

### Router
$aura = new RouterContainer();
$routes = $aura->getMap();

$routes->get('home', '/', HelloAction::class);
$routes->get('about', '/about', AboutAction::class);
$routes->get('blog', '/blog', IndexAction::class);
$routes->get('blog_show', '/blog/{id}', ShowAction::class)->tokens(['id' => '\d+']);

$router = new AuraRouterAdapter($aura);
$resolver = new ActionResolver();

### PreProcessing

//if (preg_match('#json"i', $request->getHeader('Content-Type'))) {
//    $request = $request->withParsedBody(json_decode(($request->getBody()->getContents())));
//}

### Running
$request = ServerRequestFactory::fromGlobals();
try {
    $result = $router->match($request);
    //добавляем все атрибуты из роута в реквест
    foreach ($result->getAttributes() as $attribute => $value) {
        $request = $request->withAttribute($attribute, $value);
    }
    ### Action
    $handler = $result->getHandler();
    $action = $resolver->resolve($handler);
    $response = $action($request, $router);
} catch (RequestNotMatchedException $e) {
//    $response = new JsonResponse(['error' => 'Undefined page'], 404);
    $response = new HtmlResponse('Undefined page', 404);
}

### PostProcessing

$response = $response->withHeader('X-Developer', 'eagle');

### Sending

$emitter = new SapiEmitter();
$emitter->emit($response);