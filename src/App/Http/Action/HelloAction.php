<?php
namespace App\Http\Action;

закончил 39-45

use Framework\Http\Router\Router;
use Framework\Views\HomePage;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;

class HelloAction
{
    public function __invoke(ServerRequestInterface $request)
    {
        $name = $request->getQueryParams()['name'] ?? 'Guest';


        return new HtmlResponse($this->render('hello.php', $name));
    }

    private function render(string $view, string $name)
    {
        ob_start();
        require 'templates/' . $view;
        return ob_get_clean();
    }
}