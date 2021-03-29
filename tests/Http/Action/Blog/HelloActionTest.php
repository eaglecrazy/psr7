<?php

namespace Tests\Http\Action\Blog;

use App\Http\Action\HelloAction;
use Aura\Router\RouterContainer;
use Framework\Http\Router\AuraRouterAdapter;
use Framework\Http\Template\TemplateRenderer;
use PHPUnit\Framework\TestCase;
use Zend\Diactoros\ServerRequest;

class HelloActionTest extends TestCase
{
    /**
     * @var TemplateRenderer
     */
    private TemplateRenderer $renderer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->renderer = new TemplateRenderer('templates');
    }

    public function testGuest()
    {
        $action   = new HelloAction($this->renderer);
        $request  = new ServerRequest();
        $response = $action($request);

        self::assertEquals(200, $response->getStatusCode());
        self::assertStringContainsString('Hello Guest', $response->getBody()->getContents());
    }

    public function testEagle()
    {
        $action   = new HelloAction($this->renderer);
        $request  = (new ServerRequest())->withQueryParams(['name' => 'Eagle']);
        $response = $action($request);

        self::assertEquals(200, $response->getStatusCode());
        self::assertStringContainsString('Hello Eagle', $response->getBody()->getContents());
    }
}