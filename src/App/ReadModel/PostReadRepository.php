<?php

namespace App\ReadModel;

use App\ReadModel\Views\PostView;
use DateTimeImmutable;
use Exception;
use PDO;

class PostReadRepository
{

    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @return PostView[]
     * @throws Exception
     */
    public function getAll(int $limit = 10, int $offset = 0): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM posts ORDER BY id DESC LIMIT ? OFFSET ?');
        $stmt->execute([$limit, $offset]);

        return array_map([$this, 'hydratePost'], $stmt->fetchAll());
    }

    /**
     * @throws Exception
     */
    public function find($id): ?PostView
    {
        $stmt = $this->pdo->prepare('select * from posts where id = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return ($row ? $this->hydratePost($row) : null);

    }

    /**
     * @throws Exception
     */
    private function hydratePost(array $row): PostView
    {
        $view = new PostView();

        $view->id      = $row['id'];
        $view->date    = new DateTimeImmutable($row['date']);
        $view->title   = $row['title'];
        $view->content = $row['content'];

        return $view;
    }

    public function countAll()
    {
        $stmt = $this->pdo->query('select COUNT(id) FROM posts');
        return $stmt->fetchColumn();
    }
}
