<?php

use Framework\Http\Middleware\ErrorHandler\ErrorResponseGenerator;
use Infrastructure\Framework\Http\Middleware\ErrorHandler\WhoopsErrorResponseGeneratorFactory;
use Infrastructure\Framework\Http\Middleware\ErrorHandler\WhoopsRunFactory;
use App\Console\Command\FixtureCommand;
use Whoops\RunInterface;
use Infrastructure\App\Console\Command\FixtureCommandFactory;

return [
    'dependencies' => [
        'factories' => [
            ErrorResponseGenerator::class => WhoopsErrorResponseGeneratorFactory::class,
            RunInterface::class           => WhoopsRunFactory::class,
            FixtureCommand::class         => FixtureCommandFactory::class,
        ],
    ],

    'doctrine' => [
        'configuration' => [
            'orm_default' => [
                'result_cache' => 'array',
                'metadata_cache' => 'array',
                'query_cache' => 'array',
                'hydration_cache' => 'array',
            ],
        ],
        'driver' => [
            'entities' => [
                'cache' => 'array',
            ],
        ],
    ],



    'console' => [
        'commands' => [
//            FixtureCommand::class,
        ],

        'debug' => true,
    ],
];