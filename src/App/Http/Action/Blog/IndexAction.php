<?php

namespace App\Http\Action\Blog;

use App\ReadModel\PostReadRepository;
use Framework\Http\Template\TemplateRenderer;
use Zend\Diactoros\Response\HtmlResponse;

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