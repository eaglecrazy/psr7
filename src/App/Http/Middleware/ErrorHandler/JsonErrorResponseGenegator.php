<?php

namespace App\Http\Middleware\ErrorHandler;

use App\Http\Middleware\ErrorHandler;
use App\Http\Middleware\Utils;
use Framework\Http\Template\TemplateRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;
use Zend\Diactoros\Response\JsonResponse;

class JsonErrorResponseGenegator implements ErrorHandler\ErrorResponseGenegator
{

    private bool                 $debug;

    private TemplateRenderer     $template;

    public function __construct(bool $debug, TemplateRenderer $template)
    {
        $this->debug    = $debug;
        $this->template = $template;
    }

    public function generate(ServerRequestInterface $request, Throwable $e): ResponseInterface
    {
        $view = $this->debug ? 'error/error-debug' : 'error/error';

        return new JsonResponse([
            'request'   => $request,
            'exception' => $e,
        ], Utils::getStatusCode($e));
    }

}