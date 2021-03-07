<?php

use App\Http\Action\AboutAction;
use App\Http\Action\Blog\IndexAction;
use App\Http\Action\Blog\ShowAction;
use App\Http\Action\HelloAction;


use Framework\Http\Router\Exception\RequestNotMatchedException;
use Framework\Http\Router\RouteCollection;
use Framework\Http\Router\Router;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\ServerRequestFactory;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';
require 'helpers.php';



class myself{
    public function xxx(){
        return self::class;
    }
}

 ### Initialization

session_start();
$request = ServerRequestFactory::fromGlobals();

$routes = new RouteCollection();
$routes->get('home', '/', new HelloAction());
$routes->get('about', '/about', new AboutAction());
$routes->get('blog', '/blog', new IndexAction());
$routes->get('blog_show', '/blog/{id}', new ShowAction());

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
    $response = $action($request, $router);
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