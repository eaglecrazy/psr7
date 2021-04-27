<?php

namespace Infrastructure\Framework\Template\Twig;

use Framework\Http\Template\Twig\Extension\TwigRouteExtension;
use Psr\Container\ContainerInterface;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

class TwigEnvironmentFactory
{
    function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config');

        $templateDir = $config['twig']['template_dir'];
        $cacheDir    = $config['twig']['cache_dir'];
        $debug       = $config['debug'];

        $loader = new FilesystemLoader();
        $loader->addPath($templateDir);

        $environment = new Environment($loader, [
            'cache'            => false,
            'debug'            => false,
            'strict_variables' => false,
            'auto_reload'      => false,
        ]);

        if ($debug) {
            $environment->addExtension(new DebugExtension());
        }

        $environment->addExtension($container->get(TwigRouteExtension::class));

        foreach ($config['twig']['extensions'] as $extension) {
            $environment->addExtension($container->get($extension));
        }

        return $environment;
    }
}