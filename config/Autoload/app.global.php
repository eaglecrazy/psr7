<?php

use App\Http\Middleware\ErrorHandlerMiddleware;
use App\Http\Middleware\NotFoundHandler;
use Aura\Router\RouterContainer;
use Framework\Http\Application;
use Framework\Http\MiddlewareResolver;
use Framework\Http\Router\AuraRouterAdapter;
use Framework\Http\Router\Router;
use Framework\Http\Template\TemplateRenderer;
use Framework\Http\Template\Twig\Extension\TwigRouteExtension;
use Framework\Http\Template\Twig\TwigRenderer;
use Psr\Container\ContainerInterface;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
use Zend\Diactoros\Response;
use Zend\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;

return [
    'dependencies' => [
        'abstract_factories' => [
            ReflectionBasedAbstractFactory::class,
        ],

        'factories' => [
            Application::class =>
                function (ContainerInterface $container) {
                    return new Application(
                        $container->get(MiddlewareResolver::class),
                        $container->get(Router::class),
                        $container->get(NotFoundHandler::class),
                        new Response());
                },

            Router::class =>
                function () {
                    return new AuraRouterAdapter(new RouterContainer());
                },

            MiddlewareResolver::class =>
                function (ContainerInterface $container) {
                    return new MiddlewareResolver($container);
                },

            ErrorHandlerMiddleware::class =>
                function (ContainerInterface $container) {
                    return new ErrorHandlerMiddleware(
                        $container->get('config')['debug'],
                        $container->get(TemplateRenderer::class)
                    );
                },

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
                    'cache'=> $debug ? false : $cacheDir,
                    'debug' => $debug,
                    'strict_variables' => $debug,
                    'auto_reload' => $debug,
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

        'debug' => false,
//    'debug' => true,
];