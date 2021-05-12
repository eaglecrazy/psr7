<?php

namespace Framework\Http\Router;

class Result
{
    private string $name;

    private $handler;

    private array $attributes;

    public function __construct($name, $handlers, array $attributes)
    {
        $this->name       = $name;
        $this->handler    = $handlers;
        $this->attributes = $attributes;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getHandler()
    {
        return $this->handler;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
