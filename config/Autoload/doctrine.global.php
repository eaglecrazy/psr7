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
        'configuration' => [
            'orm_default' => [
                'result_cache' => 'filesystem',
                'metadata_cache' => 'filesystem',
                'query_cache' => 'filesystem',
                'hydration_cache' => 'filesystem',
            ],
        ],
        'driver' => [
            'orm_default' => [
                'class'   => MappingDriverChain::class,
                'drivers' => [
                    'App\Entity' => 'entities',
                ],
            ],
            'entities'    => [
                'class' => AnnotationDriver::class,
                'cache' => 'filesystem',
                'paths' => ['src/App/Entity'],
            ],
        ],
        'cache' => [
            'filesystem' => [
                'class' => Doctrine\Common\Cache\FilesystemCache::class,
                'directory' => 'var/cache/doctrine',
            ],
        ],
    ],
];
