<?php

namespace Framework\Container;

use ArrayAccess;
use Closure;
use Psr\Container\ContainerInterface;
use ReflectionClass;

class Container implements ArrayAccess, ContainerInterface
{
    private array $definitions = [];

    private array $results     = [];

    public function __construct(array $definitions = [])
    {
        $this->definitions = $definitions;
    }

    public function get($id)
    {
        if (array_key_exists($id, $this->results)) {
            return $this->results[$id];
        }

        if (!array_key_exists($id, $this->definitions)) {
            if (class_exists($id)) {
                $reflection = new ReflectionClass($id);

                $arguments = [];

                if (($constructor = $reflection->getConstructor()) !== null) {
                    foreach ($constructor->getParameters() as $param) {
                        if ($paramClass = $param->getClass()) {
                            $arguments[] = $this->get($paramClass->getName());
                        } elseif ($param->isArray()) {
                            $arguments[] = [];
                        } else {
                            if (!$param->isDefaultValueAvailable()) {
                                throw new ServiceNotFoundException('Unable to resolve "' . $param->getName() . '"' . ' in service "' . $id . '"');
                            }
                            $arguments[] = $param->getDefaultValue();
                        }
                    }
                }
                $result = $reflection->newInstanceArgs($arguments);

                return $this->results[$id] = $result;
            }
            throw new ServiceNotFoundException('Undefined service "' . $id . '"');
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

    public function has($id): bool
    {
        return array_key_exists($id, $this->definitions) || class_exists($id);
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