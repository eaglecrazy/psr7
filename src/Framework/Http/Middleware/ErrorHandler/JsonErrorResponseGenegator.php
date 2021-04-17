<?php

namespace Framework\Http\Middleware\ErrorHandler;

use Framework\Http\Middleware\ErrorHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;
use Zend\Diactoros\Response;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Stratigility\Utils;

class JsonErrorResponseGenegator implements ErrorHandler\ErrorResponseGenegator
{
    public function generate(ServerRequestInterface $request, Throwable $e): ResponseInterface
    {
        return new JsonResponse([
            'error' => $e->getMessage(),
        ], Utils::getStatusCode($e, new Response()));
    }

}