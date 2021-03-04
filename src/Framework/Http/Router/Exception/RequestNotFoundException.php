<?php

namespace Framework\Http\Router\Exception;

use LogicException;
use Psr\Http\Message\ServerRequestInterface;

class RequestNotFoundException extends LogicException
{
    private string $name;

    private array $params;

    public function __construct($name, array $params)
    {
        parent::__construct('Route "' . $name . '" not found');
        $this->name   = $name;
        $this->params = $params;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getParams(): array
    {
        return $this->params;
    }
}