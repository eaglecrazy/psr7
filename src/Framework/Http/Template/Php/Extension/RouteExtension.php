<?php

namespace Framework\Http\Template\Php\Extension;

use Framework\Http\Router\Router;
use Framework\Http\Template\Php\Extension;
use Framework\Http\Template\Php\PhpRenderer;
use Framework\Http\Template\Php\SimpleFunction;

class RouteExtension extends Extension
{
    private Router $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function getFunctions(): array
    {
        return [
            new SimpleFunction('path', [$this, 'generatePath']),
            new SimpleFunction('map',  [$this, 'map'], true),
        ];
    }

    public function generatePath($name, array $params = []): string
    {
        return $this->router->generate($name, $params);
    }

    public function map(PhpRenderer $renderer, $x, $y): string
    {
        return $renderer->render('wigets/map', [
            'x' => $x,
            'y' => $y,
        ]);
    }
}