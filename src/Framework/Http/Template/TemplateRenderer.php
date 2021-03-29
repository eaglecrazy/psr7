<?php

namespace Framework\Http\Template;

class TemplateRenderer
{
    public function render(string $view, array $params = [])
    {
        $templateFile = 'templates/' . $view . '.php';

        ob_start();
        extract($params, EXTR_OVERWRITE);
        require $templateFile;
        return ob_get_clean();
    }
}