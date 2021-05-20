<?php

namespace App\Console\Command;

use App\Service\FileManager;
use Framework\Console\Command;
use Framework\Console\Input;
use Framework\Console\Output;
use InvalidArgumentException;

class CacheClearCommand extends Command
{
    private array  $paths;

    /**
     * @var FileManager
     */
    private FileManager $files;

    public function __construct(array $paths, FileManager $files)
    {
        $this->paths       = $paths;
        $this->files       = $files;
        $this->name        = 'cache:clear';
        $this->description = 'Clear cache';
    }

    public function execute(Input $input, Output $output): void
    {
        $output->writeln('<comment>Clearing </comment><info>cache!</info>');

        $alias = $input->getArgument(1);

        if (empty($alias)) {
            $alias = $input->choose('Chooser path', array_merge(['all'], array_keys($this->paths)));
        }

        if ($alias === 'all') {
            $paths = $this->paths;
        } else {
            if (!array_key_exists($alias, $this->paths)) {
                throw new InvalidArgumentException('Unknown path alias "' . $alias . '"' . PHP_EOL);
            }
            $paths = [$alias => $this->paths[$alias]];
        }

        foreach ($paths as $path) {
            if ($this->files->exists($path)) {
                $output->writeln('Remove ' . $path);
                $this->files->delete($path, $output);
            } else {
                $output->comment('Skip ' . $path);
            }
        }

        $output->info('Done!');
    }
}
