<?php

use App\Http\Middleware\BasicAuthMiddleware;
use App\Http\Middleware\CredentialsMiddleware;
use App\Http\Middleware\ProfilerMiddleware;
use Framework\Middleware\DispatchMiddleware;
use Framework\Middleware\RouteMiddleware;

//$app->pipe(new ErrorHandlerMiddleware($params['debug']));
$app->pipe(CredentialsMiddleware::class);
$app->pipe(ProfilerMiddleware::class);
$app->pipe(RouteMiddleware::class);
$app->pipe('cabinet', BasicAuthMiddleware::class);
$app->pipe(DispatchMiddleware::class);