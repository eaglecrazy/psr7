<?php

namespace Framework\Http\Router\Route;

use Framework\Http\Router\Result;
use Psr\Http\Message\ServerRequestInterface;

class RegexpRoute implements Route
{
    public $name;

    public $pattern;

    public $handler;

    public $tokens;

    public $methods;

    public function __construct($name, $pattern, $handler, array $methods, array $tokens = [])
    {
        $this->name    = $name;
        $this->pattern = $pattern;
        $this->handler = $handler;
        $this->tokens  = $tokens;
        $this->methods = $methods;
    }

    /**
     * Определение, подходит ли этот роут
     *
     * @param ServerRequestInterface $request
     * @return Result
     */
    public function match(ServerRequestInterface $request): ?Result
    {
        //если не совпадает метод, то маршрут пропускаем
        if ($this->methods && !(in_array($request->getMethod(), $this->methods, true))) {
            return null;
        }

        //генерируем регулярное выражение на основе шаблона из роута
        $pattern = preg_replace_callback('~\{([^\}]+)\}~', function ($matches) {
            $argument = $matches[1];
            $replace  = $this->tokens[$argument] ?? '[^}]+';
            return '(?P<' . $argument . '>' . $replace . ')';
        }, $this->pattern);

        //проверяем путь по этому регулярному выражению
        $path = $request->getUri()->getPath();
        if (preg_match('~^' . $pattern . '$~i', $path, $matches)) {
            //это нужный нам роут
            return new Result(
                $this->name,
                $this->handler,
                array_filter($matches, '\is_string', ARRAY_FILTER_USE_KEY)
            );
        }
        return null;
    }

    public function generate($name, array $params = []): ?string
    {
        $arguments = array_filter($params);

        if ($name !== $this->name) {
            return null;
        }

        $url = preg_replace_callback('~\{([^\}]+)\}~', function ($matches) use (&$arguments) {
            $argument = $matches[1];

            //если в аргументах нет такого параметра, то кидаем исключение
            if (!array_key_exists($argument, $arguments)) {
                throw new \InvalidArgumentException('Missing parameter "' . $argument . '"');
            }
            return $arguments[$argument];
        }, $this->pattern);

        if ($url !== null) {
            return $url;
        }
    }
}