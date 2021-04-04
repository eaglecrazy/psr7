<?php

namespace App\Http\Action\Blog;

use App\Http\Middleware\NotFoundHandler;
use App\ReadModel\PostReadRepository;
use Framework\Http\Template\TemplateRenderer;
use phpDocumentor\Reflection\Types\This;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;

class ShowAction
{
    public function __construct(PostReadRepository $posts, TemplateRenderer $template)
    {
        $this->posts    = $posts;
        $this->template = $template;
    }

    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        if (!$post = $this->posts->find($request->getAttribute('id'))) {
            return $next($request);
        }

        return new HtmlResponse($this->template->render('app/blog/show', ['post' => $post]));
    }
}