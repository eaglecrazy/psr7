<?php

use Framework\Container\Container;

$container = new Container();

### Parameters

$container->set('debug', true);
$container->set('users', ['admin' => 'password']);
$container->set('dsn', 'mysql:localhost;dbname=courson');
$container->set('username', 'homestead');
$container->set('password', 'secret');
$container->set('address', 'ya@mail.ru');
$container->set('per_page', 10);

### Services

$container->set('db', function (Container $container) {
    return new PDO(
        $container->get('dsn'),
        $container->get('username'),
        $container->get('password')
    );
});

$container->set('mailer', function ()