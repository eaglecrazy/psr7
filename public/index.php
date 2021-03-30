<?php

use Framework\Http\Application;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequestFactory;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;

//закончил 01-07

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

$container = require 'config/container.php';

/** @var Application $app */
$app = $container->get(Application::class);

require 'config/pipeline.php';
require 'config/routes.php';

$request  = ServerRequestFactory::fromGlobals();
$response = $app->run($request, new Response());

$emitter = new SapiEmitter();
$emitter->emit($response);