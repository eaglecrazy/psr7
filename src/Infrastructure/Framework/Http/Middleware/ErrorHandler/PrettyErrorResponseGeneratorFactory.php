<?php

namespace Infrastructure\Framework\Http\Middleware\ErrorHandler;

use Framework\Http\Template\TemplateRenderer;
use Psr\Container\ContainerInterface;
use Zend\Diactoros\Response;

class PrettyErrorResponseGeneratorFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new PrettyErrorResponseGenerator(
            $container->get(TemplateRenderer::class),
            new Response(),
            [
                'error' => 'error/error',
                '404'   => 'error/404',
                '403'   => 'error/403',
            ]);
    }
}