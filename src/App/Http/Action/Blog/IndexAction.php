<?php

namespace App\Http\Action\Blog;

use App\ReadModel\Pagination;
use App\ReadModel\PostReadRepository;
use Exception;
use Framework\Http\Template\TemplateRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;

class IndexAction implements RequestHandlerInterface
{
    const PER_PAGE = 5;

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

    /**
     * @throws Exception
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $pager = new Pagination(
            $this->posts->countAll(),
            $request->getAttribute('page') ?: 1,
            self::PER_PAGE
        );

        $posts = $this->posts->getAll($pager->getLimit(), $pager->getOffset());

        return new HtmlResponse($this->template->render('app/blog/index', [
            'posts' => $posts,
            'pager' => $pager,
        ]));
    }
}
