<?php

namespace App\Http\Middleware;

use Framework\Http\Template\TemplateRenderer;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;

class NotFoundHandler
{
    private TemplateRenderer $template;

    public function __construct(TemplateRenderer $template)
    {
        $this->template = $template;
    }

    public function __invoke(ServerRequestInterface $request): HtmlResponse
    {
        return new HtmlResponse($this->template->render('error/404', [
            'request' => $request,
        ]), 404);
    }
}