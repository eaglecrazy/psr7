<?php

namespace Framework\Http\Middleware;

use Framework\Http\MiddlewareResolver;
use Framework\Http\Router\AuraRouterAdapter;
use Framework\Http\Router\Exception\RequestNotMatchedException;
use Framework\Http\Router\Result;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DispatchMiddleware
{
    private MiddlewareResolver $resolver;

    public function __construct(
        MiddlewareResolver $resolver
    ) {
        $this->resolver = $resolver;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        //getAttribute(Result::class) - получает результат работы маршрутизатора
        if (!$result = $request->getAttribute(Result::class)) {
            //если его нет, то стандартный ответ - 404
            return $next($request, $response);
        }
        //роут найден, нормальная работа
        $middleware = $this->resolver->resolve($result->getHandler());
        return $middleware($request, $response, $next);
    }
}
