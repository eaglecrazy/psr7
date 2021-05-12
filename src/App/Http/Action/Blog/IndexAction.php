<?php

namespace App\Http\Action\Blog;

use App\ReadModel\PostReadRepository;
use Framework\Http\Template\TemplateRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;

class IndexAction implements RequestHandlerInterface
{
    /**
     * @var PostReadRepository
     */
    private PostReadRepository $posts;

    /**
     * @var TemplateRenderer
     */
    private TemplateRenderer $template;

    public function __construct(PostReadRepository $posts, TemplateRenderer $template)
    {
        $this->posts    = $posts;
        $this->template = $template;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $posts = $this->posts->getAll();
        return new HtmlResponse($this->template->render('app/blog/index', [
            'posts' => $posts,
        ]));
    }
}
