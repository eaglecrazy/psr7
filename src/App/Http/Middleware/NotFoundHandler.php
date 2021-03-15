<?php

namespace App\Http\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;

class NotFoundHandler
{
    public function __invoke(ServerRequestInterface $sri = null): HtmlResponse
    {
        return new HtmlResponse('Undefined page', 404);
    }
}