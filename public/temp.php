<?php

use Framework\Http\Application;
use Framework\Http\Template\Php\Extension\RouteExtension;
use Framework\Http\Template\Php\PhpRenderer;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

$container = require 'config/container.php';

/** @var Application $app */
$app = $container->get(Application::class);

require 'config/pipeline.php';
require 'config/routes.php';

$renderer = new PhpRenderer('templates');
$renderer->addExtension($container->get(RouteExtension::class));
$html = $renderer->render('app/hello');
echo $html;