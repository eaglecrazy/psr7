<?php

namespace Infrastructure\Framework\Http\Pipeline;

use Framework\Http\MiddlewareResolver;
use Psr\Container\ContainerInterface;
use Zend\Diactoros\Response;

class MiddlewareResolverFactory
{
    function __invoke(ContainerInterface $container) {
        return new MiddlewareResolver($container, new Response());
    }
}