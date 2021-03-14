<?php

namespace Framework\Http\Pipeline;

use phpDocumentor\Reflection\Types\Callable_;
use Psr\Http\Message\ServerRequestInterface;

class Next
{
    private           $default;
    private \SplQueue $queue;

    public function __construct(callable $default, \SplQueue $queue)
    {
        $this->default = $default;
        $this->queue   = $queue;
    }

    public function __invoke(ServerRequestInterface $request)
    {
        if ($this->queue->isEmpty()) {
            return ($this->default)($request);
        };

        $current = $this->queue->dequeue();

        return $current($request, function (ServerRequestInterface $request) {
            return $this($request);
        });
    }
}