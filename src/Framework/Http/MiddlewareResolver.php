<?php

namespace Framework\Http;

use Framework\Http\Pipeline\HandlerWrapper;
use Framework\Http\Pipeline\Pipeline;
use Framework\Http\Pipeline\UnknownMiddlewareTypeException;
use PHPUnit\Framework\MockObject\UnknownClassException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;

class MiddlewareResolver
{
    public function resolve($handler, ResponseInterface $responsePrototype): callable
    {
        //если это массив хэндлеров, то создаём пайплайн с ними
        if (is_array($handler)) {
            return $this->createPipe($handler, $responsePrototype);
        }

        //если это строка, то возвращаем анонимку, в которой создаём объект
        if (is_string($handler)) {
            return function (ServerRequestInterface $request, ResponseInterface $response, callable $next)
            use ($handler) {
                $middleware = $this->resolve(new $handler(), $response);
                return $middleware($request, $response, $next);
            };
        }

        if ($handler instanceof MiddlewareInterface) {
            return function (ServerRequestInterface $request, ResponseInterface $response, callable $next)
            use ($handler) {
                return $handler->process($request, new HandlerWrapper($next));
            };
        }

        //если объект и инвоком и 2 параметрами и 2 каллэйбл, то вызываем с двумя параметрами
        if (is_object($handler)) {
            $reflection = new \ReflectionObject($handler);
            if ($reflection->hasMethod('__invoke')) {
                $method     = $reflection->getMethod('__invoke');
                $parameters = $method->getParameters();
                if (count($parameters) === 2 && $parameters[1]->isCallable()) {
                    return function (ServerRequestInterface $request, ResponseInterface $response, callable $next)
                    use ($handler) {
                        return $handler($request, $next);
                    };
                }
                //если объект, то возвращаем его
                return $handler;
            }
        }
        throw new UnknownMiddlewareTypeException($handler);
    }

    private function createPipe(
        array $handlers
    ): Pipeline {
        $pipeline = new Pipeline();
        foreach ($handlers as $handler) {
            $pipeline->pipe($this->resolve($handler));
        }
        return $pipeline;
    }
}