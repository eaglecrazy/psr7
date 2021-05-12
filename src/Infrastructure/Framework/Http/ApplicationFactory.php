<?php

namespace Infrastructure\Framework\Http;

use App\Http\Middleware\NotFoundHandler;
use Framework\Http\Application;
use Framework\Http\MiddlewareResolver;
use Framework\Http\Router\Router;
use Psr\Container\ContainerInterface;
use Zend\Diactoros\Response;

class ApplicationFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new Application(
            $container->get(MiddlewareResolver::class),
            $container->get(Router::class),
            $container->get(NotFoundHandler::class),
            new Response()
        );
    }
}
