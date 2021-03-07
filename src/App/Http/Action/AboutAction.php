<?php
namespace App\Http\Action;


use Framework\Http\Router\Router;
use Framework\Views\HomePage;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;

class AboutAction
{
    public function __invoke(ServerRequestInterface $request, Router $router)
    {
        return new HtmlResponse((new HomePage($router))->getMenu() . 'PSR-7 Framework');
    }
}