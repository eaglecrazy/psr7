<?php

use Framework\Http\Application;
use Framework\Http\Middleware\ErrorHandler\ErrorHandlerMiddleware;
use Framework\Http\Middleware\ErrorHandler\ErrorResponseGenerator;
use Framework\Http\MiddlewareResolver;
use Framework\Http\Router\Router;
use Infrastructure\App\Logger\LoggerFactory;
use Infrastructure\Framework\Http\ApplicationFactory;
use Infrastructure\Framework\Http\Middleware\ErrorHandler\ErrorHandlerMiddlewareFactory;
use Infrastructure\Framework\Http\Middleware\ErrorHandler\PrettyErrorResponseGeneratorFactory;
use Infrastructure\Framework\Http\Pipeline\MiddlewareResolverFactory;
use Infrastructure\Framework\Http\Router\AuraRouterFactory;
use Psr\Log\LoggerInterface;
use Zend\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;

//закончил 3-50

return [
    'dependencies' => [
        'abstract_factories' => [
            ReflectionBasedAbstractFactory::class,
        ],

        'factories' => [

            Application::class => ApplicationFactory::class,

            Router::class => AuraRouterFactory::class,

            MiddlewareResolver::class => MiddlewareResolverFactory::class,

            ErrorHandlerMiddleware::class => ErrorHandlerMiddlewareFactory::class,

            ErrorResponseGenerator::class => PrettyErrorResponseGeneratorFactory::class,

            LoggerInterface::class => LoggerFactory::class,
        ],
    ],

    'debug' => false,
    'config_cache_enabled' => true,
];