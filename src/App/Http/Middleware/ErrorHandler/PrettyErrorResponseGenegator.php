<?php

namespace App\Http\Middleware\ErrorHandler;

use App\Http\Middleware\ErrorHandler;
use App\Http\Middleware\Utils;
use Framework\Http\Template\TemplateRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;
use Zend\Diactoros\Response\HtmlResponse;

class PrettyErrorResponseGenegator implements ErrorHandler\ErrorResponseGenegator
{

    private bool $debug;
    private TemplateRenderer $template;

    public function __construct(bool $debug, TemplateRenderer $template)
    {
        $this->debug    = $debug;
        $this->template = $template;
    }

    public function generate(ServerRequestInterface $request, Throwable $e): ResponseInterface
    {
        $view = $this->debug ? 'error/error-debug' : 'error/error';

        return new HtmlResponse($this->template->render($view, [
            'request'   => $request,
            'exception' => $e,
        ]), self::getStatusCode($e));
    }

    private static function getStatusCode(Throwable $e): int
    {
        $code = $e->getCode();

        if ($code >= 400 && $code < 600) {
            return $code;
        }
        return 500;
    }

}