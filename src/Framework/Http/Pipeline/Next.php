<?php

namespace Framework\Http\Pipeline;

use phpDocumentor\Reflection\Types\Callable_;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Next
{
    private ResponseInterface $response;
    private                   $default;
    private \SplQueue         $queue;

    public function __construct(callable $default, ResponseInterface $response, \SplQueue $queue)
    {
        $this->default  = $default;
        $this->queue    = $queue;
        $this->response = $response;
    }

    public function __invoke(ServerRequestInterface $request)
    {
        if ($this->queue->isEmpty()) {
            return ($this->default)($request);
        };

        $current = $this->queue->dequeue();

        return $current($request, $this->response, function (ServerRequestInterface $request)
    {
        return $this($request);
    });
    }
}