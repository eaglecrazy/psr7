<?php

namespace Infrastructure\Framework\Template;

use Framework\Http\Template\Twig\TwigRenderer;
use Psr\Container\ContainerInterface;
use Twig\Environment;

class TemplateRendererFactory
{
    function __invoke(ContainerInterface $container)
    {
        return new TwigRenderer(
            $container->get(Environment::class),
            $container->get('config')['templates']['extension']);
    }
}