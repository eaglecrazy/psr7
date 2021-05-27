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
    public function getAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM posts ORDER BY date DESC ');

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map([$this, 'hydratePost'], $rows);
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
}
