<?php

namespace App\Console\Command;


use InvalidArgumentException;
use RuntimeException;
use function Zend\Stratigility\path;

class CacheClearCommand
{
    49 минут

    private array $paths = [
        'twig' => 'var/cache/twig',
        'log' => 'var/log',
    ];

    public function execute(array $args)
    {
//        $alias = $args[0];

            fwrite(STDOUT, 'Input path: ');
            $alias = trim(fgets(STDIN));
            print_r($alias);
            die();

        if(!empty($alias)){
            if(!array_key_exists($alias, $this->paths)){
                throw new InvalidArgumentException('Unknown path alias "' . $alias . '"' . PHP_EOL);
            }
            $path = $this->paths[$alias];
            if(file_exists($path)){
                echo 'Remove ' . $path . PHP_EOL;
                self::delete($path);
            }
        } else {
            foreach ($this->paths as $path){
                if(!file_exists($path)){
                    continue;
                }
                echo 'Remove ' . $path . PHP_EOL;
                self::delete($path);
            }
        }

        echo 'Done!' . PHP_EOL;
    }


    private function delete(string $path): void
    {
        if (!file_exists($path)) {
            throw new RuntimeException('Undefined path ' . $path);
        }

        if (is_dir($path)) {
            foreach (scandir($path, SCANDIR_SORT_ASCENDING) as $item) {
                if ($item === '.' || $item === '..') {
                    continue;
                }
                $this->delete($path . DIRECTORY_SEPARATOR . $item);

                echo 'Remove ' . $path . PHP_EOL;
            }
            if (!rmdir($path)) {
                throw new RuntimeException('Unable to delete directory ' . $path);
            }
        } else {
            echo 'Remove ' . $path . PHP_EOL;
            if (!unlink($path)) {
                throw new RuntimeException('Unable to delete file ' . $path);
            };
        }
    }
}
