<?php

use App\Console\Command\CacheClearCommand;
use Infrastructure\App\Console\CacheClearCommandFactory;

return [
    'dependencies' => [
        'factories' => [
            CacheClearCommand::class => CacheClearCommandFactory::class,
        ],
    ],
    'console'      => [
        'cachePaths' => [
            'twig' => 'var/cache/twig',
            'log'  => 'var/log',
        ],
    ],
];