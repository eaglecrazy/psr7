<?php

namespace Framework\Http\Template;

class PhpRenderer implements TemplateRenderer
{
    private string $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function render(string $view, array $params = [])
    {
        $templateFile = $this->path . '/' . $view . '.php';

        ob_start();
        extract($params, EXTR_OVERWRITE);

        $params = [];
        $extends = null;

        require $templateFile;
        $content = ob_get_clean();

        if($extends === null){
            return $content;
        }

        return $this->render($extends, ['content' => $content]);
    }
}