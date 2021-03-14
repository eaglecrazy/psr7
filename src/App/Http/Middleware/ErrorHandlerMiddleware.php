<?php

namespace App\Http\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;

class ErrorHandlerMiddleware
{
    private $debug;

    public function __construct(bool $debug = true)
    {
        $this->debug = $debug;
    }

    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        try {
            return $next($request);
        } catch (\Throwable $e) {
            if ($this->debug) {
                return new JsonResponse([
                    'error'   => 'Server error',
                    'code'    => $e->getCode(),
                    'message' => $e->getMessage(),
                ], 500);
            }
            return new HtmlResponse('Server error', 500);
        }
    }
}