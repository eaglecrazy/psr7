<?php

use Framework\Http\Application;
use Framework\Http\Template\TemplateRenderer;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

$container = require 'config/container.php';

/** @var Application $app */
$app = $container->get(Application::class);

require 'config/pipeline.php';
require 'config/routes.php';

$renderer = $container->get(TemplateRenderer::class);
$html = $renderer->render('app/hello');
echo $html;