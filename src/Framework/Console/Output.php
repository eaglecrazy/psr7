<?php

namespace Framework\Console;

class Output
{
    public function write(string $message)
    {
        echo $this->process($message);
    }

    public function writeln(string $message)
    {
        echo $this->process($message) . PHP_EOL;
    }

    public function comment(string $message)
    {
        $this->writeln("\033[33m" . $message . "\033[0m");
    }

    public function info(string $message)
    {
        $this->writeln("\033[32m" . $message . "\033[0m");
    }

    private function process(string $message)
    {
        return strtr($message, [
            '<comment>'  => "\033[33m",
            '</comment>' => "\033[0m",
            '<info>'     => "\033[32m",
            '</info>'    => "\033[0m",
        ]);
    }
}