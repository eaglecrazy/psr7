<?php

namespace Infrastructure\App;

use Doctrine\DBAL\Driver\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;

class PDOFactory
{
    public function __invoke(ContainerInterface $container): ?Connection
    {
        /** @var EntityManagerInterface $em */
        $em = $container->get(EntityManagerInterface::class);

        return $em->getConnection()->getWrappedConnection();
    }
}