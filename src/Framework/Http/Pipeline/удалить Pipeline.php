<?php

namespace Framework\Http\Pipeline;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Pipeline
{
    private \SplQueue         $queue;

    public function __construct()
    {
        $this->queue = new \SplQueue();
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next
    ): ResponseInterface {
        $delegate = new Next($next, $response, clone $this->queue);
        return $delegate($request);
    }

    public function pipe($middleware): void
    {
        $this->queue->enqueue($middleware);
    }
}