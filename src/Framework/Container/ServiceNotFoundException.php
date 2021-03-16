<?php

namespace Framework\Container;

use Throwable;

class ServiceNotFoundException extends \InvalidArgumentException
{
    private $type;

    public function __construct($type)
    {
        parent::__construct('Unknown middleware type.');
        $this->type = $type;
    }

    public function getType(){
        return $this->type;
    }
}