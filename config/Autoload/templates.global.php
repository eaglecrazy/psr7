<?php

use App\Http\Middleware\ErrorHandlerMiddleware;
use App\Http\Middleware\NotFoundHandler;
use Aura\Router\RouterContainer;
use Framework\Http\Application;
use Framework\Http\MiddlewareResolver;
use Framework\Http\Router\AuraRouterAdapter;
use Framework\Http\Router\Router;
use Framework\Http\Template\TemplateRenderer;
use Psr\Container\ContainerInterface;
use Zend\Diactoros\Response;

return [
    'factories' => [
        Application::class =>
            function (ContainerInterface $container) {
                return new Application(
                    $container->get(MiddlewareResolver::class),
                    $container->get(Router::class),
                    $container->get(NotFoundHandler::class),
                    new Response());
            },

        Router::class =>
            function () {
                return new AuraRouterAdapter(new RouterContainer());
            },

        MiddlewareResolver::class =>
            function (ContainerInterface $container) {
                return new MiddlewareResolver($container);
            },

        ErrorHandlerMiddleware::class =>
            function (ContainerInterface $container) {
                return new ErrorHandlerMiddleware(
                    $container->get('config')['debug'],
                    $container->get(TemplateRenderer::class)
                );
            },
    ],

    'templates' => [
        'extension' => '.html.twig',
    ],
    'twig' => [
        'template_dir' => 'templates',
        'cache_dir' => 'var/cache/twig',
        'extensions' => [],
    ]

];