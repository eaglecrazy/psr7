<?php

namespace Framework\Http;

use Framework\Http\Pipeline\Pipeline;
use Psr\Http\Message\ServerRequestInterface;

class MiddlewareResolver
{
    public function resolve($handler): callable
    {
        //если это массив хэндлеров, то создаём пайплайн с ними
        if (is_array($handler)) {
            return $this->createPipe($handler);
        }

        //если это строка, то возвращаем анонимку, в которой создаём объект
        if (is_string($handler)) {
            return function (ServerRequestInterface $request, callable $next) use ($handler) {
                $object = new $handler();
                return $object($request, $next);
            };
        }

        //если объект, то возвращаем его
        return $handler;
    }

    private function createPipe(array $handlers): Pipeline
    {
        $pipeline = new Pipeline();
        foreach ($handlers as $handler){
            $pipeline->pipe($this->resolve($handler));
        }
        return $pipeline;
    }
}