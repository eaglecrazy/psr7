<?php

use App\Http\Middleware\ErrorHandler\DebugErrorResponseGenegator;
use App\Http\Middleware\ErrorHandler\ErrorResponseGenegator;
use App\Http\Middleware\ErrorHandler\PrettyErrorResponseGenegator;
use App\Http\Middleware\NotFoundHandler;
use Aura\Router\RouterContainer;
use Framework\Http\Application;
use Framework\Http\MiddlewareResolver;
use Framework\Http\Router\AuraRouterAdapter;
use Framework\Http\Router\Router;
use Framework\Http\Template\TemplateRenderer;
use Psr\Container\ContainerInterface;
use Zend\Diactoros\Response;
use Zend\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;

return [
    'dependencies' => [
        'abstract_factories' => [
            ReflectionBasedAbstractFactory::class,
        ],

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
                    return new MiddlewareResolver($container, new Response());
                },

            ErrorResponseGenegator::class => function (ContainerInterface $container) {
                if ($container->get('config')['debug']) {
                    return new DebugErrorResponseGenegator(
                        $container->get(TemplateRenderer::class),
                        new Response(),
                        'error/error-debug');
                }
                return new PrettyErrorResponseGenegator(
                    $container->get(TemplateRenderer::class),
                    new Response(),
                    [
                        'error' => 'error/error',
                        '404'   => 'error/404',
                        '403'   => 'error/403',
                    ],
                );
            },
        ],
    ],

//        'debug' => false,
    'debug'        => true,
];