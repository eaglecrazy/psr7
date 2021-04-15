<?php

namespace App\Http\Action;

use Framework\Http\Template\TemplateRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;

class HelloAction implements RequestHandlerInterface
{
    private TemplateRenderer $renderer;

    public function __construct(TemplateRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new HtmlResponse($this->renderer->render('app/hello'));
    }
}