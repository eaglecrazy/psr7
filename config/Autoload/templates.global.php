<?php

use Framework\Http\Template\TemplateRenderer;
use Infrastructure\Framework\Template\TemplateRendererFactory;
use Infrastructure\Framework\Template\Twig\TwigEnvironmentFactory;
use Twig\Environment;

return [
    'dependencies' => [
        'factories' => [
            TemplateRenderer::class => TemplateRendererFactory::class,
            Environment::class => TwigEnvironmentFactory::class,
            Stormiix\Twig\Extension\MixExtension::class => Infrastructure\App\Twig\MixExtensionFactory::class,
        ],
    ],

    'templates' => [
        'extension' => '.html.twig',
    ],

    'twig' => [
        'template_dir' => 'templates',
        'cache_dir'    => 'var/cache/twig',
        'extensions' => [
            Stormiix\Twig\Extension\MixExtension::class,
        ],
    ],

    'mix' => [
        'root' => 'public/build',
        'manifest' => 'mix-manifest.json',
    ],

    'cachePaths' => [
        'twig' => 'var/cache/twig',
    ],

];