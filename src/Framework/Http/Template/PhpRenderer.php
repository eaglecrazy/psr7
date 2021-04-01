<?php

namespace Framework\Http\Template;

use SplStack;


//Закончил 2-15

class PhpRenderer implements TemplateRenderer
{
    private string $path;
    private ?string $extend;
    public array $blocks = [];
    private SplStack $blockNames;

    public function __construct(string $path)
    {
        $this->path = $path;
        $this->blockNames = new SplStack();
    }

    public function render(string $name): string
    {
        $templateFile = $this->path . '/' . $name . '.php';

        ob_start();

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
        return $this->blocks[$name] ?? '';
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
}