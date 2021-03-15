<?php

namespace Framework;

use App\Http\Middleware\NotFoundHandler;
use Framework\Http\MiddlewareResolver;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Stratigility\MiddlewarePipe;

class Application extends MiddlewarePipe
{
    private MiddlewareResolver $resolver;
    private NotFoundHandler $default;

    public function __construct(MiddlewareResolver $resolver, callable $default, ResponseInterface $responsePrototype)
    {
        parent::__construct();
        $this->resolver = $resolver;
        $this->setResponsePrototype($responsePrototype);
        $this->default = $default;
    }

    public function pipe($path, $middleware = null): MiddlewarePipe
    {
        if($middleware === null){
            return parent::pipe($this->resolver->resolve($path, $this->responsePrototype));
        }
        return parent::pipe($this->resolver->resolve($middleware, $this->responsePrototype));
    }

    public function run(ServerRequestInterface $request, ResponseInterface $response)
    {
        return $this($request, $response, $this->default);
    }
}