<?php

namespace Tests\Http\Action\Blog;

use App\Http\Action\HelloAction;
use Framework\Http\Router\RouteCollection;
use Framework\Http\Router\Router;
use PHPUnit\Framework\TestCase;
use Zend\Diactoros\ServerRequest;

class HelloActionTest extends TestCase
{
    public function testGuest()
    {
        $routes = new RouteCollection();
        $routes->get('home', '/', new HelloAction());

        $action   = new HelloAction();
        $request  = new ServerRequest();
        $response = $action($request, new Router($routes));

        self::assertEquals(200, $response->getStatusCode());
        self::assertStringContainsString('Hello Guest!', $response->getBody()->getContents());
    }

    public function testEagle()
    {
        $routes = new RouteCollection();
        $routes->get('home', '/', new HelloAction());

        $action   = new HelloAction();
        $request  = (new ServerRequest())->withQueryParams(['name' => 'Eagle']);
        $response = $action($request, new Router($routes));

        self::assertEquals(200, $response->getStatusCode());
        self::assertStringContainsString('Hello Eagle!', $response->getBody()->getContents());
    }
}