<?php

namespace App\Http\Action\Blog;

use Framework\Http\Router\Router;
use PDO;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

class IndexAction
{
    public function __construct(PDO $db, int $perPage)
    {

    }

    public function __invoke(ServerRequestInterface $request)
    {
        return new JsonResponse([
            ['id' => 1, 'title' => 'The First post'],
            ['id' => 2, 'title' => 'The Second post'],
        ]);
    }

    public function blog_show(ServerRequestInterface $request)
    {
        $id = $request->getAttribute('id');
        if ($id > 2) {
            return new JsonResponse(['error' => 'Undefined page'], 404);
        }
        return new JsonResponse(['id' => $id, 'title' => 'Post #' . $id]);
    }
}