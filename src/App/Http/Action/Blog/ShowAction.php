<?php
namespace App\Http\Action\Blog;

use Framework\Http\Router\Router;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;

class ShowAction
{
    public function __invoke(ServerRequestInterface $request, Router $router)
    {
        $id = $request->getAttribute('id');
        if ($id > 2) {
            return new HtmlResponse('Undefined page', 404);
        }
        return new JsonResponse(['id' => $id, 'title' => 'Post #' . $id]);
    }
}