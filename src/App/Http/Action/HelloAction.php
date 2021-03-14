<?php
namespace App\Http\Action;


use Framework\Http\Router\Router;
use Framework\Views\HomePage;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;

class HelloAction
{
    public function __invoke(ServerRequestInterface $request)
    {
        $name = $request->getQueryParams()['name'] ?? 'Guest';
        return new HtmlResponse('Hello ' . $name . '!');
    }
}