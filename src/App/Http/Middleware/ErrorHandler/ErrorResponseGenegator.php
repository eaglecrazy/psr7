<?php

namespace App\Http\Middleware\ErrorHandler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;

interface ErrorResponseGenegator
{
    public function generate(ServerRequestInterface $request, Throwable $e): ResponseInterface;
}