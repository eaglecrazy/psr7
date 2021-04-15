<?php

//ЗАКОНЧИЛ

use Framework\Http\Application;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response\SapiEmitter;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

$container = require 'config/container.php';

/** @var Application $app */
$app = $container->get(Application::class);

require 'config/pipeline.php';
require 'config/routes.php';

$request  = ServerRequestFactory::fromGlobals();
$response = $app->handle($request);

$emitter = new SapiEmitter();
$emitter->emit($response);