<?php

use App\Http\Middleware\NotFoundHandler;
use Aura\Router\RouterContainer;
use Framework\Http\Application;
use Framework\Http\Middleware\ErrorHandler\ErrorHandlerMiddleware;
use Framework\Http\Middleware\ErrorHandler\ErrorResponseGenerator;
use Framework\Http\MiddlewareResolver;
use Framework\Http\Router\AuraRouterAdapter;
use Framework\Http\Router\Router;
use Infrastructure\App\Logger\LoggerFactory;
use Infrastructure\Framework\Http\Middleware\ErrorHandler\ErrorHandlerMiddlewareFactory;
use Infrastructure\Framework\Http\Middleware\ErrorHandler\PrettyErrorResponseGeneratorFactory;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
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

            ErrorHandlerMiddleware::class => ErrorHandlerMiddlewareFactory::class,

            ErrorResponseGenerator::class => PrettyErrorResponseGeneratorFactory::class,

            LoggerInterface::class => LoggerFactory::class,
        ],
    ],
];