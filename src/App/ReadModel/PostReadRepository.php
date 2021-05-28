<?php

namespace App\ReadModel;

use App\Entity\Post\Post;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

class PostReadRepository
{

    private EntityRepository $repository;

    public function __construct(EntityRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return int
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function countAll(): int
    {
        return $this->repository
            ->createQueryBuilder('p')
            ->select('COUNT(p)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function all(int $limit = 10, int $offset = 0): array
    {
        return $this->repository
            ->createQueryBuilder('p')
            ->select('p')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->orderBy('p.createDate', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param $id
     * @return Post|object|null
     */
    public function find($id): ?Post
    {
        return $this->repository->find($id);
    }
}
