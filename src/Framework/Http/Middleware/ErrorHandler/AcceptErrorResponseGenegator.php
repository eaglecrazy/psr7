<?php

namespace Framework\Http\Middleware\ErrorHandler;

use Framework\Http\Middleware\ErrorHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;
use Zend\Diactoros\Response;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Stratigility\Utils;

class AcceptErrorResponseGenegator implements ErrorHandler\ErrorResponseGenegator
{
    private JsonErrorResponseGenegator   $json;

    private PrettyErrorResponseGenegator $pretty;

    public function __construct(JsonErrorResponseGenegator $json, PrettyErrorResponseGenegator $pretty)
    {
        $this->json   = $json;
        $this->pretty = $pretty;
    }

    public function generate(ServerRequestInterface $request, Throwable $e): ResponseInterface
    {
        $accept = $request->getHeaderLine('Accept');

        $parts = explode(';', $accept);
        $mime  = trim(array_shift($parts));

        if (preg_match('#[/+]json$#', $mime)) {
            return $this->json->generate($request, $e);
        }
        return $this->pretty->generate($request, $e);
    }

}