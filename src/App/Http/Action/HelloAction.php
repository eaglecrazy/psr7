<?php
namespace App\Http\Action;


use Framework\Http\Template\TemplateRenderer;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;

class HelloAction
{
    private TemplateRenderer $renderer;

    public function __construct(TemplateRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    public function __invoke()
    {
        return new HtmlResponse($this->renderer->render('app/hello'));
    }
}