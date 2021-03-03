<?php
echo __DIR__ . PHP_EOL;
echo dirname(__DIR__) . PHP_EOL;
chdir(dirname(__DIR__));
require 'src/Framework/Http/Request.php';

$request = new Request();

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

session_start();




$name = $request->getQueryParams()['name'] ?? 'Guest';
$lang = getLang($_GET, $_COOKIE, $_SESSION, $_SERVER, 'en');
header('X-Developer: Eagle');
echo $name . ' ' . $lang;