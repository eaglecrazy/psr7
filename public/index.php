<?php

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

### PreProcessing

//if (preg_match('#json"i', $request->getHeader('Content-Type'))) {
//    $request = $request->withParsedBody(json_decode(($request->getBody()->getContents())));
//}

### Action

$path   = $request->getUri()->getPath();
$action = null;

if ($path === '/') {
    $action = function (ServerRequestInterface $request) {
        $name = $request->getQueryParams()['name'] ?? 'Guest';
        return new HtmlResponse('Hello, ' . $name . '!');
    };
} elseif ($path === '/about') {
    $action = function () {
        return new HtmlResponse('PSR-7 Framework');
    };
} elseif ($path === '/blog') {
    $action = function (ServerRequestInterface $request) {
        return new JsonResponse([
            ['id' => 1, 'title' => 'The First post'],
            ['id' => 2, 'title' => 'The Second post'],
        ]);
    };
} elseif (preg_match('#^/blog/(?P<id>\d+)$#i', $path, $matches)) {
    $request = $request->withAttribute('id', $matches['id']);
    $action  = function (ServerRequestInterface $request) {
        $id = $request->getAttribute('id');
        if ($id > 2) {
            return new JsonResponse(['error' => 'Undefined page'], 404);
        }
        return new JsonResponse(['id' => $id, 'title' => 'Post #' . $id]);
    };
}

if ($action) {
    $response = $action($request);
} else {
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