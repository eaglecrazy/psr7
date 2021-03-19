<?php

use App\Http\Action\Blog\IndexAction;
use Framework\Container\Container;

$container = new Container();

### Parameters

$container->set('debug', true);
$container->set('users', ['admin' => 'password']);
$container->set('dsn', 'mysql:localhost;dbname=courson');
$container->set('username', 'homestead');
$container->set('password', 'secret');

$container->set('config', require ('../config/params.php'));

$container->set('address', 'ya@mail.ru');
$container->set('per_page', 10);

### Services

$container->set('db', function (Container $container) {
    return new PDO(
        $container->get('config')['db']['dsn'],
        $container->get('config')['db']['username'],
        $container->get('config')['db']['password'],
    );
});

$container->set('mailer', function (Container $container) {
    return new Mailer($container->get('adress'));
});

$container->set('action . blog_index', function (Container $container) {
    return new IndexAction($container->get('db'), $container->get('per_page'));
});