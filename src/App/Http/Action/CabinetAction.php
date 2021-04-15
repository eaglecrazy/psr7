<?php

namespace App\Http\Action;

use App\Http\Middleware\BasicAuthMiddleware;
use Framework\Http\Template\TemplateRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;

class CabinetAction implements RequestHandlerInterface
{
    private TemplateRenderer $renderer;

    public function __construct(TemplateRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $name = $request->getAttribute(BasicAuthMiddleware::ATTRIBUTE);
        return new HtmlResponse($this->renderer->render('app/cabinet', [
            'name' => $name,
        ]));
    }
}