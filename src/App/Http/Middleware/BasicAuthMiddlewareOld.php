<?php

namespace App\Http\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\EmptyResponse;

class BasicAuthMiddlewareOld
{
    public const ATTRIBUTE = '_user';

    private array $users;

    public function __construct(array $users)
    {
        $this->users = $users;
    }

    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        $username = $request->getServerParams()['PHP_AUTH_USER'] ?? null;
        $password = $request->getServerParams()['PHP_AUTH_PW'] ?? null;
        if (!empty($username) && !empty($password)) {
            foreach ($this->users as $name => $pass) {
                if ($username === $name && $password === $pass) {
                    return $next($request->withAttribute(static::ATTRIBUTE, $username));
                }
            }
        }

        return (new EmptyResponse)(401, 'WWW-Authenticate', 'Basic realm=Restricted area');
    }
}