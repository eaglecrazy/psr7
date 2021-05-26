<?php

namespace Framework\Console;

use InvalidArgumentException;

class Application
{

    private array $commands = [];

    public function add(Command $command)
    {
        $this->commands[] = $command;
    }

    public function run(Input $input, Output $output): void
    {
        if ($name = $input->getArgument(0)) {
            $command = $this->resolveCommand($name);
            $command->execute($input, $output);
        } else {
            $this->renderHelp($output);
        }
    }

    public function resolveCommand(string $name): Command
    {
        foreach ($this->commands as $command) {
            if ($command->getName() === $name) {
                return $command;
            }
        }
        throw new InvalidArgumentException('Undefined command ' . $name);
    }

    private function renderHelp(Output $output): void
    {
        $output->writeln('<comment>Available commands:</comment>');
        $output->writeln('');
        foreach ($this->commands as $command) {
            $output->writeln('<info>' . $command->getName() . '</info>' . "\t" . $command->getDescription());
        }
        $output->writeln('');
    }
}