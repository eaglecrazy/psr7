<?php

namespace Framework\Http\Router\Exception;

use LogicException;
use Psr\Http\Message\ServerRequestInterface;

class RequestNotMatchedException extends LogicException
{
    private ServerRequestInterface $request;

    public function __construct(ServerRequestInterface $request)
    {
        parent::__construct('Matches not found');
        $this->request = $request;
    }

    public function getRequest()
    {
        return $this->request;
    }
}
