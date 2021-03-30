<?php

namespace Tests\Http\Action\Blog;

use App\Http\Action\HelloAction;
use Framework\Http\Template\TemplateRenderer;
use PHPUnit\Framework\TestCase;

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

    public function test()
    {
        $action   = new HelloAction($this->renderer);
        $response = $action();

        self::assertEquals(200, $response->getStatusCode());
        self::assertStringContainsString('Hello!', $response->getBody()->getContents());
    }
}