<?php

namespace Framework\Container;

class Container
{
    private array $definitions = [];

    public function set($id, $value)
    {
        $this->definitions[$id] = $value;
    }

    public function get($id)
    {
        if (!array_key_exists($id, $this->definitions)) {
            throw new ServiceNotFoundException('Undefined parameter ' . $id);
        }


        return $this->definitions[$id];
    }
}