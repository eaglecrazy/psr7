<?php

use Framework\Http\Application;
use Framework\Http\Template\TemplateRenderer;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

$container = require 'config/container.php';

/** @var Application $app */
$app = $container->get(Application::class);

require 'config/pipeline.php';
require 'config/routes.php';

class TwigRenderer implements TemplateRenderer{

    private Environment $twig;
    private string      $extension;

    public function __construct(Environment $twig, string $extension)
    {
        $this->twig = $twig;
        $this->extension = $extension;
    }

    public function render(string $name, $params = []): string
    {
        return $this->twig->render($name . $this->extension, $params);
    }
}

$loader = new FilesystemLoader();
$loader->addPath('templates');

$twig = new Environment($loader, [
    'cache'=> 'var/cache/twig',
    'auto_reload' => $debug,
    'debug' => $debug,
]);

$renderer = new TwigRenderer($twig, '.html.twig');
$html = $renderer->render('app/hello');
echo $html;