<?php
namespace App\Http\Action;


use Framework\Http\Router\Router;
use Framework\Http\Template\TemplateRenderer;
use Framework\Views\HomePage;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;

class AboutAction
{
    public function __construct(TemplateRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request)
    {
        return new HtmlResponse('PSR-7 Framework');
    }
}