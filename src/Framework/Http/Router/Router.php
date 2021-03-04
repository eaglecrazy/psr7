<?php

namespace Framework\Http\Router;

use Framework\Http\Router\Exception\RequestNotFoundException;
use Framework\Http\Router\Exception\RequestNotMatchedException;
use Psr\Http\Message\ServerRequestInterface;

class Router
{

    private RouteCollection $routes;

    public function __construct(RouteCollection $routes)
    {
        $this->routes = $routes;
    }

    /**
     * Поиск подходящего маршрута из коллекции маршрутов.
     *
     * @param ServerRequestInterface $request
     * @return Result
     */
    public function match(ServerRequestInterface $request): Result
    {
        //просмотр всех маршрутов
        foreach ($this->routes->getRoutes() as $route) {
            //если не совпадает метод, то маршрут пропускаем
            if ($route->methods && !(in_array($request->getMethod(), $route->methods, true))) {
                continue;
            }

            //генерируем регулярное выражение на основе шаблона из роута
            $pattern = preg_replace_callback('~\{([^\}]+)\}~', function ($matches) use ($route) {
                $argument = $matches[1];
                $replace  = $route->tokens[$argument] ?? '[^}]+';
                return '(?P<' . $argument . '>' . $replace . ')';
            }, $route->pattern);

            //проверяем путь по этому регулярному выражению
            $path = $request->getUri()->getPath();
            if (preg_match('~^' . $pattern . '$~i', $path, $matches)) {
                //подходящий роут найден
                return new Result(
                    $route->name,
                    $route->handler,
                    array_filter($matches, '\is_string', ARRAY_FILTER_USE_KEY)
                );
            }
        }
        throw new RequestNotMatchedException($request);
    }

    //создаём url
    public function generate($name, array $params = []): string
    {
        $arguments = array_filter($params);

        foreach ($this->routes->getRoutes() as $route)
        {
            //если имя не совпадает, то пропускаем
            if ($name !== $route->name) {
                continue;
            }
            $url = preg_replace_callback('~\{([^\}]+)\}~', function ($matches) use (&$arguments) {
                $argument = $matches[1];
                //если в аргументах нет такого параметра, то кидаем исключение
                if (!array_key_exists($argument, $arguments)) {
                    throw new \InvalidArgumentException('Missing parameter "' . $argument . '"');
                }
                return $argument[$argument];
            }, $route->pattern);

            if ($url !== null) {
                return $url;
            }
        }
        throw new RequestNotFoundException($name, $params);
    }
}