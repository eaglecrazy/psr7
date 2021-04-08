<?php

namespace Framework\Http\Template\Php;

class SimpleFunction
{
    public string $name;
    public $callback;
    public bool $needRenderer;

    public function __construct(string $name, callable $callback, bool $needRenderer = false)
    {
        $this->name         = $name;
        $this->callback     = $callback;
        $this->needRenderer = $needRenderer;
    }
}