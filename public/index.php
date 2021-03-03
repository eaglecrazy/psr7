<?php

use Framework\Http\Request;

chdir(dirname(__DIR__));
require'vendor/autoload.php';

### Initialization
session_start();
$request = (new Request())
    ->withQueryParams($_GET)
    ->withParsedBody($_POST);


### Action

function getLang(array $get, array $cookie, array $session, array $server, $default)
{
    return
        !empty($get['lang']) ? $get['lang'] :
            (
            !empty($cookie['lang']) ? $cookie['lang'] :
                (
                !empty($session['lang']) ? $session['lang'] :
                    (
                    !empty($server['HTTP_ACCEPT_LANGUAGE']) ? substr($server['HTTP_ACCEPT_LANGUAGE'], 0, 2) : $default
                    )
                )
            );
}

$name = $request->getQueryParams()['name'] ?? 'Guest';
$lang = getLang($_GET, $_COOKIE, $_SESSION, $_SERVER, 'en');
header('X-Developer: Eagle');
echo $name . ' ' . $lang;