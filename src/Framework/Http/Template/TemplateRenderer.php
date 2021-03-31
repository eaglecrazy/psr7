<?php

namespace Framework\Http\Template;

interface TemplateRenderer
{
    public function render(string $name, array $params = []);
}