<?php

namespace App\Http\Action\Blog;

use Framework\Http\Router\Router;
use PDO;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

class IndexAction
{
        public function __invoke()
        {
            return new JsonResponse(
                [
                    ['id' => 2, 'title' => 'second'],
                    ['id' => 2, 'title' => 'first'],
                ]
            );
        }

//    private $db;
//    private $perPage;
//
//    public function __construct(PDO $db, int $perPage)
//    {
//        $this->db = $db;
//        $this->perPage = $perPage;
//    }
//
//    public function __invoke(ServerRequestInterface $request)
//    {
//        $page = $request->getQueryParams()['page'] ?? 1;
//
//        $limit = $this->perPage;
//        $offset = ($page - 1) * $this->perPage;
//
//        $stmt = $this->db->query("SELECT * FROM users ORDER BY id DESC LIMIT $limit OFFSET $offset");
//
//        return new JsonResponse($stmt->fetchAll());
//    }
//
//    public function blog_show(ServerRequestInterface $request)
//    {
//        $id = $request->getAttribute('id');
//        if ($id > 2) {
//            return new JsonResponse(['error' => 'Undefined page'], 404);
//        }
//        return new JsonResponse(['id' => $id, 'title' => 'Post #' . $id]);
//    }
}