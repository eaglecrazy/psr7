<?php

namespace App\Http\Action\Blog;

use App\ReadModel\PostReadRepository;
use Framework\Http\Router\Router;
use Framework\Http\Template\TemplateRenderer;
use PDO;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;

class IndexAction
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

    public function __invoke()
    {
        $posts = $this->posts->getAll();

        return new HtmlResponse($this->template->render('app/blog/index', [
            'posts' => $posts
        ]));
    }
}