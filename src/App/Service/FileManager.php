<?php

namespace App\Service;

use Framework\Console\Output;
use RuntimeException;

class FileManager
{
    public function exists(string $path):bool
    {
        return file_exists($path);
    }

    public function delete(string $path, Output $output): void
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