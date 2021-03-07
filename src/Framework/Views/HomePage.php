<?php

namespace Framework\Views;

use Framework\Http\Router\Router;

class HomePage
{

    public Router $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function getMenu()
    {
        $fline = '*****************************************<br>';
        $line  = '<br>*****************************************<br>';

        $home  = $this->getLink('home');
        $eagle = $this->getLink('home', [], ['name' => 'eagle']);
        $about = $this->getLink('about');
        $blog  = $this->getLink('blog');
        $blog1 = $this->getLink('blog_show', ['id' => 1]);
        $blog2 = $this->getLink('blog_show', ['id' => 2]);
        $blog5 = $this->getLink('blog_show', ['id' => 5]);

        return $fline . $home . $eagle . $about . $blog . $blog1 . $blog2 . $blog5 . $line;
    }

    private function getLink($name, $params = [], $attr = [])
    {
        if(!$this->router->hasRoute($name)){
            return '';
        }
        $url = $this->router->generate($name, $params);
        if ($attr) {
            $url .= '?';
            foreach ($attr as $key => $value) {
                $url .= $key . '=' . $value;
            }
        }
        return '<a href="' . $url . '">' . $url . '</a><br>';
    }
}

