<?php

use App\Http\Middleware\NotFoundHandler;
use Aura\Router\RouterContainer;
use Framework\Http\Application;
use Framework\Http\Middleware\ErrorHandler\ErrorHandlerMiddleware;
use Framework\Http\Middleware\ErrorHandler\ErrorResponseGenerator;
use Framework\Http\Middleware\ErrorHandler\WhoopsErrorResponseGenerator;
use Framework\Http\MiddlewareResolver;
use Framework\Http\Router\AuraRouterAdapter;
use Framework\Http\Router\Router;
use Framework\Http\Template\TemplateRenderer;
use Infrastructure\Framework\Http\Middleware\ErrorHandler\LogErrorListener;
use Infrastructure\Framework\Http\Middleware\ErrorHandler\PrettyErrorResponseGenerator;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Whoops\Handler\PrettyPageHandler;
use Whoops\RunInterface;
use Zend\Diactoros\Response;
use Zend\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;

закончил 3-43

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

            ErrorHandlerMiddleware::class => function(ContainerInterface $container){
                $middleware = new ErrorHandlerMiddleware(
                    $container->get(ErrorResponseGenerator::class),
                );
                $middleware->addListener($container->get(LogErrorListener::class));
                return $middleware;
            },

            ErrorResponseGenerator::class => function (ContainerInterface $container) {
                return new PrettyErrorResponseGenerator(
                    $container->get(TemplateRenderer::class),
                    new Response(),
                    [
                        'error' => 'error/error',
                        '404'   => 'error/404',
                        '403'   => 'error/403',
                    ],
                );
            },

            LoggerInterface::class => function(ContainerInterface $container){
                $logger = new Logger('App');
                $logger->pushHandler(new StreamHandler(
                    'var/log/application.log',
                    $container->get('config')['debug'] ? Logger::DEBUG : Logger::WARNING
                ));
                return $logger;
            }
        ],
    ],

//            'debug' => false,
    'debug'        => true,
];