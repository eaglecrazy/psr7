<?php

namespace Framework\Http\Template;

class PhpRenderer implements TemplateRenderer
{
    private string $path;
    private ?string $extends;
    private array $params = [];

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function render(string $name, array $params = []): string
    {
        $templateFile = $this->path . '/' . $name . '.php';

        ob_start();
        extract($params, EXTR_OVERWRITE);

        $this->extends = null;

        require $templateFile;
        $content = ob_get_clean();
        if($this->extends === null){

            return $content;
        }

        return $this->render($this->extends, [
            'content' => $content
        ]);
    }
}