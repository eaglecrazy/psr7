<?php
namespace App\Http\Action;


use Framework\Http\Router\Router;
use Framework\Views\HomePage;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;

class HelloAction
{
    public function __invoke(ServerRequestInterface $request, Router $router)
    {
        $name = $request->getQueryParams()['name'] ?? 'Guest';
        return new HtmlResponse((new HomePage($router))->getMenu() . 'Hello ' . $name . '!');
    }
}