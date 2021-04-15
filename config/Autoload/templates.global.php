<?php

use Framework\Http\Template\TemplateRenderer;
use Framework\Http\Template\Twig\Extension\TwigRouteExtension;
use Framework\Http\Template\Twig\TwigRenderer;
use Psr\Container\ContainerInterface;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

return [
    'dependencies' => [
        'factories' => [
            TemplateRenderer::class => function (ContainerInterface $container)
            {
                return new TwigRenderer(
                    $container->get(Environment::class),
                    $container->get('config')['templates']['extension']);
            },
            Environment::class => function (ContainerInterface $container)
            {
                $config = $container->get('config');

                $templateDir = $config['twig']['template_dir'];
                $cacheDir = $config['twig']['cache_dir'];
                $debug = $config['debug'];

                $loader = new FilesystemLoader();
                $loader->addPath($templateDir);

                $environment = new Environment($loader, [
//                    'cache'=> $debug ? false : $cacheDir,
                    'cache'=> false,
//                    'debug' => $debug,
                    'debug' => false,
//                    'strict_variables' => $debug,
                    'strict_variables' => false,
//                    'auto_reload' => $debug,
                    'auto_reload' => false,
                ]);

                if($debug){
                    $environment->addExtension(new DebugExtension());
                }

                $environment->addExtension($container->get(TwigRouteExtension::class));

                foreach ($config['twig']['extensions'] as $extension) {
                    $environment->addExtension($container->get($extension));
                }

                return $environment;
            }
        ],
    ],

    'templates' => [
        'extension' => '.html.twig',
    ],

    'twig' => [
        'template_dir' => 'templates',
        'cache_dir'    => 'var/cache/twig',
        'extensions'   => [],
    ],

];