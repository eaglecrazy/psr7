<?php

namespace Infrastructure\App\Console;

use App\Console\Command\CacheClearCommand;
use App\Service\FileManager;
use Psr\Container\ContainerInterface;

class CacheClearCommandFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new
        CacheClearCommand($container->get('config')['console']['cachePaths'],
        $container->get(FileManager::class)
        );
    }
}