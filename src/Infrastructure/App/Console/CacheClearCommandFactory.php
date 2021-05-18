<?php

namespace Infrastructure\App\Console;

use App\Console\Command\CacheClearCommand;
use Psr\Container\ContainerInterface;

class CacheClearCommandFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new CacheClearCommand($container->get('config')['console']['cachePaths']);
    }
}