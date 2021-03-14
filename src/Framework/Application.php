<?php

namespace Framework;

use App\Http\Middleware\NotFoundHandler;
use Framework\Http\MiddlewareResolver;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Application extends Http\Pipeline\Pipeline
{
    private MiddlewareResolver $resolver;
    private NotFoundHandler $default;

    public function __construct(MiddlewareResolver $resolver, $default)
    {
        parent::__construct();
        $this->resolver = $resolver;
        $this->default = $default;
    }

    public function pipe($middleware): void
    {
        parent::pipe($this->resolver->resolve($middleware));
    }

    public function run(ServerRequestInterface $request, ResponseInterface $response)
    {
        return $this($request, $response, $this->default);
    }
}