<?php

namespace App\Http\Middleware;

use Framework\Http\Template\TemplateRenderer;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;

class ErrorHandlerMiddleware
{
    private $debug;

    /**
     * @var TemplateRenderer
     */
    private TemplateRenderer $template;

    public function __construct(bool $debug = true, TemplateRenderer $template)
    {
        $this->debug    = $debug;
        $this->template = $template;
    }

    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        try {
            return $next($request);
        } catch (Throwable $e) {
            $view = $this->debug ? 'error/error-debug' : 'error/error';

            return new HtmlResponse($this->template->render($view, [
                'request'   => $request,
                'exception' => $e,
            ]), $e->getCode() ?: 500);
        }
    }
}