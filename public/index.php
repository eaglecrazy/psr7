<?php

use Framework\Http\RequestFactory;
use Framework\Http\Response;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

### Initialization
session_start();
$request = RequestFactory::fromGlobals();

### Action

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
//$name = $request->getQueryParams()['name'] ?? 'Guest';
//$lang = getLang($_GET, $_COOKIE, $_SESSION, $_SERVER, 'en');



$response = (new Response('response-body'))
    ->withHeader('X-Developer', 'eagle');

###Sending
header('HTTP/1.0' . ' ' . $response->getStatusCode() . ' ' . $response->getReasonPhrase());


foreach ($response->getHeaders() as $name => $value) {
    header($name . ':' . $value);
}
echo $response->getBody();


ЗАКОНЧИЛ НА 1-43





