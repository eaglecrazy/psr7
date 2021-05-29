<?php

use App\Console\Command\CacheClearCommand;
use Infrastructure\App\Console\Command\CacheClearCommandFactory;
use Doctrine\DBAL\Migrations\Tools\Console\Command\DiffCommand;
use Infrastructure\App\Doctrine\Factory\DiffCommandFactory;

use Doctrine\DBAL\Migrations\Tools\Console\Command\ExecuteCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\GenerateCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\LatestCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\MigrateCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\UpToDateCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\StatusCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\VersionCommand;

return [
    'dependencies' => [
        'factories' => [
            CacheClearCommand::class => CacheClearCommandFactory::class,
//            DiffCommand::class       => DiffCommandFactory::class,

        ],
    ],
    'console'      => [
        'commands'   => [
            CacheClearCommand::class,
            ExecuteCommand::class,
            GenerateCommand::class,
            LatestCommand::class,
            MigrateCommand::class,
            DiffCommand::class,
            UpToDateCommand::class,
            StatusCommand::class,
            VersionCommand::class,
        ],
        'cachePaths' => [
            'twig'     => 'var/cache/twig',
            'log'      => 'var/log',
//            'doctrine' => 'var/cache/doctrine',
        ],
    ],
];