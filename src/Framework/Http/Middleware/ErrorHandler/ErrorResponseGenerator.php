<?php

namespace Framework\Http\Middleware\ErrorHandler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;

interface ErrorResponseGenerator
{
    public function generate(ServerRequestInterface $request, Throwable $e): ResponseInterface;
}
