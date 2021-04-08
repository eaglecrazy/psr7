<?php

namespace Framework\Http\Template\Php;

use Closure;
use Exception;
use Framework\Http\Template\TemplateRenderer;
use Framework\Http\Template\Php\Extension;
use SplStack;
use Throwable;

class PhpRenderer implements TemplateRenderer
{
    private string   $path;

    private ?string  $extend;

    public array     $blocks = [];

    private SplStack $blockNames;

    private array    $extensions = [];

    public function __construct(string $path)
    {
        $this->path       = $path;
        $this->blockNames = new SplStack();
    }

    public function addExtension(Extension $extension)
    {
        $this->extensions[] = $extension;
    }

    public function render(string $name, $params = []): string
    {
        $level = ob_get_level();
        try {
            $templateFile = $this->path . '/' . $name . '.php';

            ob_start();

            extract($params, EXTR_OVERWRITE);

            $this->extend = null;

            require $templateFile;
            $content = ob_get_clean();
            if (!$this->extend) {
                return $content;
            }
        } catch (Throwable | Exception $e) {
            while (ob_get_level() > $level) {
                ob_end_clean();
            }
            throw $e;
        }

        return $this->render($this->extend);
    }

    public function extend($view): void
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
        $name    = $this->blockNames->pop();
        if ($this->hasBlock($name)) {
            return;
        }
        $this->blocks[$name] = $content;
    }

    public function renderBlock(string $name): string
    {
        $block = $this->blocks[$name] ?? null;

        if ($block instanceof Closure) {
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
        if (!$this->hasBlock($name)) {
            return false;
        }

        $this->beginBlock($name);
        return true;
    }

    public function block($name, $content)
    {
        if ($this->hasBlock($name)) {
            return;
        }
        $this->blocks[$name] = $content;
    }

    public function encode(string $string)
    {
        return htmlspecialchars($string, ENT_QUOTES | ENT_SUBSTITUTE);
    }

    public function __call($name, $arguments)
    {
        foreach ($this->extensions as $extension) {
            foreach ($extension->getFunctions() as $function) {
                /** @var SimpleFunction $function */
                if ($function->name === $name) {
                    if($function->needRenderer) {
                        return ($function->callback)($this, ...$arguments);
                    }
                    return ($function->callback)(...$arguments);
                }
            }
        }
        throw new \InvalidArgumentException('Undefined function "' . $name . '"');
    }

}