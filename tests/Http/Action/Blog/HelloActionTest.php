<?php

namespace Tests\Http\Action\Blog;

use App\Http\Action\HelloAction;
use Aura\Router\RouterContainer;
use Framework\Http\Router\AuraRouterAdapter;
use PHPUnit\Framework\TestCase;
use Zend\Diactoros\ServerRequest;

class HelloActionTest extends TestCase
{
    public function testGuest()
    {
        $aura = new RouterContainer();
        $router = new AuraRouterAdapter($aura);
        $routes = $aura->getMap();
        $routes->get('home', '/', new HelloAction());

        $action   = new HelloAction();
        $request  = new ServerRequest();
        $response = $action($request, $router);

        self::assertEquals(200, $response->getStatusCode());
        self::assertStringContainsString('Hello Guest!', $response->getBody()->getContents());
    }

    public function testEagle()
    {
        $aura = new RouterContainer();
        $router = new AuraRouterAdapter($aura);
        $routes = $aura->getMap();
        $routes->get('home', '/', new HelloAction());

        $action   = new HelloAction();
        $request  = (new ServerRequest())->withQueryParams(['name' => 'Eagle']);
        $response = $action($request, $router);

        self::assertEquals(200, $response->getStatusCode());
        self::assertStringContainsString('Hello Eagle!', $response->getBody()->getContents());
    }
}