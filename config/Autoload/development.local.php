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
    'console'      => [
        'commands' => [
            FixtureCommand::class,
        ],

        'debug' => true,
    ],
];