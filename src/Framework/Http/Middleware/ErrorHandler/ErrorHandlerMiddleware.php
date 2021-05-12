<?php

namespace Framework\Http\Middleware\ErrorHandler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;
use Throwable;

class ErrorHandlerMiddleware implements MiddlewareInterface
{
    private ErrorResponseGenerator $responseGenerator;
    private array                  $listeners = [];

    public function __construct(ErrorResponseGenerator $responseGenerator)
    {
        $this->responseGenerator = $responseGenerator;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (Throwable $e) {
            foreach ($this->listeners as $listener) {
                $listener($e, $request);
            }

            return $this->responseGenerator->generate($request, $e);
        }
    }

    public function addListener(callable $listener): void
    {
        $this->listeners[] = $listener;
    }
}
