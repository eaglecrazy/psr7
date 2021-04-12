<?php

namespace Framework\Http;

use Framework\Http\Pipeline\HandlerWrapper;
use Framework\Http\Pipeline\UnknownMiddlewareTypeException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Zend\Stratigility\MiddlewarePipe;

class MiddlewareResolver
{
    private ContainerInterface $container;
    private ResponseInterface  $responsePrototype;

    public function __construct(ContainerInterface $container, ResponseInterface $responsePrototype)
    {
        $this->container = $container;
        $this->responsePrototype = $responsePrototype;
    }

    public function resolve($handler): callable
    {
        //если это массив хэндлеров, то создаём пайплайн с ними
        if (is_array($handler)) {
            return $this->createPipe($handler);
        }

        //если это строка, то возвращаем анонимку, в которой создаём объект
        if (is_string($handler) && $this->container->has($handler)) {
            return function (ServerRequestInterface $request, ResponseInterface $response, callable $next)
            use ($handler) {
                $middleware = $this->resolve($this->container->get($handler));
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

    private function createPipe(array $handlers): MiddlewarePipe {
        $pipeline = new MiddlewarePipe();
        foreach ($handlers as $handler) {
            $pipeline->pipe($this->resolve($handler));
        }
        return $pipeline;
    }
}