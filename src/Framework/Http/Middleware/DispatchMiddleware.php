<?php

namespace Framework\Http\Middleware;

use Framework\Http\MiddlewareResolver;
use Framework\Http\Router\AuraRouterAdapter;
use Framework\Http\Router\Exception\RequestNotMatchedException;
use Framework\Http\Router\Result;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class DispatchMiddleware implements MiddlewareInterface
{
    private MiddlewareResolver $resolver;

    public function __construct(
        MiddlewareResolver $resolver
    ) {
        $this->resolver = $resolver;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        //getAttribute(Result::class) - получает результат работы маршрутизатора
        if (!$result = $request->getAttribute(Result::class)) {
            //если его нет, то стандартный ответ - 404
            return $handler->handle($request);
        }
        //роут найден, нормальная работа
        $middleware = $this->resolver->resolve($result->getHandler());
        return $middleware->process($request, $handler);
    }
}
