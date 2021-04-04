<?php

namespace Framework\Http\Template;

use Closure;
use Framework\Http\Router\Router;
use SplStack;


//Закончил 2-40

class PhpRenderer implements TemplateRenderer
{
    private string $path;
    private ?string $extend;
    public array $blocks = [];
    private SplStack $blockNames;

    /**
     * @var Router
     */
    private Router $router;

    public function __construct(string $path, Router $router)
    {
        $this->path = $path;
        $this->blockNames = new SplStack();
        $this->router = $router;
    }

    public function render(string $name, $params = []): string
    {
        $templateFile = $this->path . '/' . $name . '.php';

        ob_start();

        extract($params, EXTR_OVERWRITE);

        $this->extend = null;

        require $templateFile;
        $content = ob_get_clean();
        if(!$this->extend){
            return $content;
        }

        return $this->render($this->extend);
    }

    public function extend($view):void
    {
        $this->extend = $view;
    }

    public function beginBlock(string $name): void
    {
        $this->blockNames->push($name);
        ob_start();
    }

    public function endBlock(): void
    {
        $content = ob_get_clean();
        $name = $this->blockNames->pop();
        if($this->hasBlock($name)){
            return;
        }
        $this->blocks[$name] = $content;
    }

    public function renderBlock(string $name): string
    {
        $block = $this->blocks[$name] ?? null;

        if($block instanceof Closure){
            return $block();
        }

        return $block ?? '';
    }

    public function hasBlock($name): bool
    {
        return array_key_exists($name, $this->blocks);
    }

    public function ensureBlock(string $name)
    {
       if(!$this->hasBlock($name)){
           return false;
       }

       $this->beginBlock($name);
       return true;

    }

    public function block($name, $content){

        if($this->hasBlock($name)){
            return;
        }
        $this->blocks[$name] = $content;
    }

    public function encode(string $string)
    {
        return htmlspecialchars($string, ENT_QUOTES | ENT_SUBSTITUTE);
    }

    public function path(string $name, $params = []):string
    {
         return $this->router->generate($name, $params);
    }
}