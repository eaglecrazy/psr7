<?php

namespace Framework\Http\Template;

class PhpRenderer implements TemplateRenderer
{
    private string $path;
    private ?string $extend;
    public array $params = [];
    public array $blocks = [];

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function render(string $name, array $params = []): string
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

        return $this->render($this->extend, [
            'content' => $content
        ]);
    }

    public function extend($view):void
    {
        $this->extend = $view;
    }

    public function beginBlock()
    {
        ob_start();
    }

    public function endBlock(string $block)
    {
        $this->blocks[$block] = ob_get_clean();
    }
}