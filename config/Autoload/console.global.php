<?php

use App\Console\Command\CacheClearCommand;
use Infrastructure\App\Console\Command\CacheClearCommandFactory;
use Doctrine\DBAL\Migrations\Tools\Console\Command\DiffCommand;
use Infrastructure\App\Doctrine\Factory\DiffCommandFactory;

return [
    'dependencies' => [
        'factories' => [
            CacheClearCommand::class => CacheClearCommandFactory::class,
            DiffCommand::class       => DiffCommandFactory::class,

        ],
    ],
    'console'      => [
        'commands'   => [
            CacheClearCommand::class,
            Doctrine\DBAL\Migrations\Tools\Console\Command\ExecuteCommand::class,
            Doctrine\DBAL\Migrations\Tools\Console\Command\GenerateCommand::class,
            Doctrine\DBAL\Migrations\Tools\Console\Command\LatestCommand::class,
            Doctrine\DBAL\Migrations\Tools\Console\Command\MigrateCommand::class,
            Doctrine\DBAL\Migrations\Tools\Console\Command\DiffCommand::class,
            Doctrine\DBAL\Migrations\Tools\Console\Command\UpToDateCommand::class,
            Doctrine\DBAL\Migrations\Tools\Console\Command\StatusCommand::class,
            Doctrine\DBAL\Migrations\Tools\Console\Command\VersionCommand::class,
        ],
        'cachePaths' => [
            'twig' => 'var/cache/twig',
            'log'  => 'var/log',
        ],
    ],
];