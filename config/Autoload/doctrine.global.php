<?php

use Doctrine\ORM\EntityManagerInterface;
use ContainerInteropDoctrine\EntityManagerFactory;
use Infrastructure\App\PDOFactory;
use Doctrine\Persistence\Mapping\Driver\MappingDriverChain;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

return [
    'dependencies' => [
        'factories' => [
            EntityManagerInterface::class => EntityManagerFactory::class,
            PDO::class                    => PDOFactory::class,
        ],
    ],

    'doctrine' => [
        'driver' => [
            'orm_default' => [
                'class'   => MappingDriverChain::class,
                'drivers' => [
                    'App\Entity' => 'entities',
                ],
            ],
            'entities'    => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => ['src/App/Entity'],
            ],
        ],
    ],
];
