<?php

use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\ServerRequestFactory;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

### Initialization
session_start();
$request = ServerRequestFactory::fromGlobals();

### Action


$name = $request->getQueryParams()['name'] ?? 'Guest';


$response = (new HtmlResponse('Hello, ' . $name . '!'))
    ->withHeader('X-Developer', 'eagle');

###Sending
header('HTTP/1.0' . ' ' . $response->getStatusCode() . ' ' . $response->getReasonPhrase());


foreach ($response->getHeaders() as $name => $values) {
    header($name . ':' . implode(', ', $values));
}
echo $response->getBody();









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