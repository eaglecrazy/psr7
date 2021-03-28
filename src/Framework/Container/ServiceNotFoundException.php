<?php

namespace Framework\Container;

use InvalidArgumentException;
use Psr\Container\NotFoundExceptionInterface;

class ServiceNotFoundException extends InvalidArgumentException implements NotFoundExceptionInterface
{
}