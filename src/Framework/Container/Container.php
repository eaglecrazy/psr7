<?php

namespace Framework\Container;

use Closure;

class Container implements \ArrayAccess
{
    private array $definitions = [];
    private       $results     = [];

    public function get($id)
    {
        if (array_key_exists($id, $this->results)) {
            return $this->results[$id];
        }

        if (!array_key_exists($id, $this->definitions)) {
            throw new ServiceNotFoundException('Undefined parameter ' . $id);
        }

        $definition = $this->definitions[$id];

        if ($definition instanceof Closure) {
            $this->results[$id] = $definition($this);
        } else {
            $this->results[$id] = $definition;
        }

        return $this->results[$id];
    }

    public function set($id, $value)
    {
        if (array_key_exists($id, $this->results)) {
            unset($this->results[$id]);
        }
        $this->definitions[$id] = $value;
    }

    public function offsetExists($offset)
    {
        // TODO: Implement offsetExists() method.
    }

    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    public function offsetUnset($offset)
    {
        // TODO: Implement offsetUnset() method.
    }
}