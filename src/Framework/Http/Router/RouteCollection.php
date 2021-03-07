<?php

namespace Framework\Http\Router;

use Framework\Http\Router\Route\RegexpRoute;

class RouteCollection
{
    private $routes = [];

    public function any($name, $pattern, $handler, array $tokens = []): void
    {
        $this->addRoute(new RegexpRoute($name, $pattern, $handler, [], $tokens));
    }

    public function get($name, $pattern, $handler, array $tokens = []): void
    {
        $this->addRoute(new RegexpRoute($name, $pattern, $handler, ['GET'], $tokens));
    }

    public function post($name, $pattern, $handler, array $tokens = []): void
    {
        $this->addRoute(new RegexpRoute($name, $pattern, $handler, ['POST'], $tokens));
    }

    /**
     * @return RegexpRoute[]
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function addRoute(RegexpRoute $route)
    {
        $this->routes[] = $route;
    }

    public function hasRoute(string $name): bool
    {
        foreach ($this->routes as $route){
            if($route->name === $name){
                return true;
            }
        }
        return false;
    }
}