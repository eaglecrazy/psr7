<?php

use Framework\Http\Router\Exception\RequestNotMatchedException;
use Framework\Http\Router\RouteCollection;
use Framework\Http\Router\Router;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\ServerRequestFactory;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

### Initialization

session_start();
$request = ServerRequestFactory::fromGlobals();

$routes = new RouteCollection();

$routes->get('home', '/', function (ServerRequestInterface $request) {
    $name = $request->getQueryParams()['name'] ?? 'Guest';
    return new HtmlResponse('Hello, ' . $name . '!');
});

$routes->get('about', '/about', function (ServerRequestInterface $request) {
    return new HtmlResponse('PSR-7 Framework');
});

$routes->get('blog', '/blog', function (ServerRequestInterface $request) {
    return new JsonResponse([
        ['id' => 1, 'title' => 'The First post'],
        ['id' => 2, 'title' => 'The Second post'],
    ]);
});

$routes->get('blog_show', '/blog/{id}', function (ServerRequestInterface $request) {
    $id = $request->getAttribute('id');
    if ($id > 2) {
        return new JsonResponse(['error' => 'Undefined page'], 404);
    }
    return new JsonResponse(['id' => $id, 'title' => 'Post #' . $id]);
}, ['id' => '\d+']);

$router = new Router($routes);

### PreProcessing

//if (preg_match('#json"i', $request->getHeader('Content-Type'))) {
//    $request = $request->withParsedBody(json_decode(($request->getBody()->getContents())));
//}

### Running
$request = ServerRequestFactory::fromGlobals();
try{
    $result = $router->match($request);
    //добавляем все атрибуты из роута в реквест
    foreach ($result->getAttributes() as $attribute => $value){
        $request = $request->withAttribute($attribute, $value);
    }
    ### Action
    $action = $result->getHandler();
    $response = $action($request);
}catch (RequestNotMatchedException $e){
    $response = new JsonResponse(['error' => 'Undefined page'], 404);
}




### PostProcessing

$response = $response->withHeader('X-Developer', 'eagle');

### Sending

$emitter = new SapiEmitter();
$emitter->emit($response);







//$lang = getLang($_GET, $_COOKIE, $_SESSION, $_SERVER, 'en');

//function getLang(array $get, array $cookie, array $session, array $server, $default)
//{
//    return
//        !empty($get['lang']) ? $get['lang'] :
//            (
//            !empty($cookie['lang']) ? $cookie['lang'] :
//                (
//                !empty($session['lang']) ? $session['lang'] :
//                    (
//                    !empty($server['HTTP_ACCEPT_LANGUAGE']) ? substr($server['HTTP_ACCEPT_LANGUAGE'], 0, 2) : $default
//                    )
//                )
//            );
//}