<?php

конец 1-03

namespace App\Console\Command;

use Framework\Console\Input;
use Framework\Console\Output;
use InvalidArgumentException;
use RuntimeException;

class CacheClearCommand
{
    private array $paths = [
        'twig' => 'var/cache/twig',
        'log'  => 'var/log',
    ];

    public function execute(Input $input, Output $output)
    {
        $alias = $input->getArgument(0);

        if (empty($alias)) {
            $alias = $input->choose('Chooser path', array_merge(['all'], array_keys($this->paths)));
        }

        if ($alias == 'all') {
            $paths = $this->paths;
        } else {
            if (!array_key_exists($alias, $this->paths)) {
                throw new InvalidArgumentException('Unknown path alias "' . $alias . '"' . PHP_EOL);
            }
            $paths = [$alias => $this->paths[$alias]];
        }

        foreach ($this->paths as $path) {
            if (file_exists($path)) {
                $output->writeln('Remove ' . $path);
                self::delete($path, $output);
            } else {
                $output->writeln('Skip ' . $path);
            }

        }

        $output->writeln('Done!');
    }

    private function delete(string $path, Output $output): void
    {
        if (!file_exists($path)) {
            throw new RuntimeException('Undefined path ' . $path);
        }

        if (is_dir($path)) {
            foreach (scandir($path, SCANDIR_SORT_ASCENDING) as $item) {
                if ($item === '.' || $item === '..') {
                    continue;
                }
                $this->delete($path . DIRECTORY_SEPARATOR . $item, $output);

                $output->writeln('Remove ' . $path);
            }
            if (!rmdir($path)) {
                throw new RuntimeException('Unable to delete directory ' . $path);
            }
        } else {
            $output->writeln('Remove ' . $path);
            if (!unlink($path)) {
                throw new RuntimeException('Unable to delete file ' . $path);
            };
        }
    }
}
