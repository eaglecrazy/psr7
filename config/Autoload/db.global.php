<?php

use Framework\Http\Application;
use Framework\Http\Middleware\ErrorHandler\ErrorHandlerMiddleware;
use Framework\Http\Middleware\ErrorHandler\ErrorResponseGenerator;
use Framework\Http\MiddlewareResolver;
use Framework\Http\Router\Router;
use Infrastructure\App\Logger\LoggerFactory;
use Infrastructure\App\PDOFactory;
use Infrastructure\Framework\Http\ApplicationFactory;
use Infrastructure\Framework\Http\Middleware\ErrorHandler\ErrorHandlerMiddlewareFactory;
use Infrastructure\Framework\Http\Middleware\ErrorHandler\PrettyErrorResponseGeneratorFactory;
use Infrastructure\Framework\Http\Pipeline\MiddlewareResolverFactory;
use Infrastructure\Framework\Http\Router\AuraRouterFactory;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Zend\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;

return [
    'dependencies' => [
        'factories' => [
            PDO::class => PDOFactory::class,
        ],
    ],

    'pdo' => [
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ],
    ],
];