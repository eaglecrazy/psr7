<?php

use App\Http\Middleware\BasicAuthMiddleware;
use App\Http\Middleware\CredentialsMiddleware;
use App\Http\Middleware\EmptyResponseMiddleware;
use App\Http\Middleware\ResponseLoggerMiddleware;
use Framework\Http\Middleware\ErrorHandler\ErrorHandlerMiddleware;
use App\Http\Middleware\ProfilerMiddleware;
use Framework\Http\Middleware\DispatchMiddleware;
use Framework\Http\Middleware\RouteMiddleware;
use Framework\Http\Middleware\BodyParamsMiddleware;

$app->pipe(ErrorHandlerMiddleware::class);
$app->pipe(ResponseLoggerMiddleware::class);
$app->pipe(CredentialsMiddleware::class);
$app->pipe(ProfilerMiddleware::class);
$app->pipe(BodyParamsMiddleware::class);
$app->pipe(RouteMiddleware::class);
$app->pipe(EmptyResponseMiddleware::class);
$app->pipe('cabinet', BasicAuthMiddleware::class);
$app->pipe(DispatchMiddleware::class);