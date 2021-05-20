<?php

declare(strict_types=1);

namespace Framework\Console;

abstract class Command
{
    protected string $name;
    protected string $description;

    abstract public function execute(Input $input, Output $output): void;

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}