<?php

namespace Framework\Middleware;

use Framework\Http\MiddlewareResolver;
use Framework\Http\Router\AuraRouterAdapter;
use Framework\Http\Router\Exception\RequestNotMatchedException;
use Framework\Http\Router\Result;
use Psr\Http\Message\ServerRequestInterface;

class RouteMiddleware
{
    private AuraRouterAdapter  $router;

    public function __construct(
        AuraRouterAdapter $router
    ) {
        $this->router = $router;
    }

    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        try {
            $result = $this->router->match($request);
            //добавляем все атрибуты из роута в реквест
            foreach ($result->getAttributes() as $attribute => $value) {
                $request = $request->withAttribute($attribute, $value);
            }
            return $next($request->withAttribute(Result::class, $result));
        } catch (RequestNotMatchedException $e) {
            return $next($request);
        }
    }
}
