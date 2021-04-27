<?php

namespace Infrastructure\Framework\Http\Router;

use Aura\Router\RouterContainer;
use Framework\Http\Router\AuraRouterAdapter;

class AuraRouterFactory
{
    function __invoke() {
        return new AuraRouterAdapter(new RouterContainer());
    }
}