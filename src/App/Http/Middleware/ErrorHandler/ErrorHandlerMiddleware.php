<?php

namespace App\Http\Middleware\ErrorHandler;

use App\Http\Middleware\ErrorHandler\PrettyErrorResponseGenegator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

class ErrorHandlerMiddleware implements MiddlewareInterface
{
    private PrettyErrorResponseGenegator $responseGenerator;

    public function __construct(PrettyErrorResponseGenegator $responseGenerator)
    {
        $this->responseGenerator = $responseGenerator;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (Throwable $e) {
            return $this->responseGenerator->generate($request, $e);
        }
    }

}