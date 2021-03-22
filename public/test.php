<?php


1-26

use App\Http\Action\Blog\IndexAction;
use Framework\Container\Container;

$container = new Container();

### Parameters
$container->set('config', require('../config/params.php'));

### Services

$container->set('db', function (Container $container) {
    return new PDO(
        $container->get('config')['db']['dsn'],
        $container->get('config')['db']['username'],
        $container->get('config')['db']['password'],
    );
});

$container->set('mailer', function (Container $container) {
    return new Mailer(
        $container->get('config')['mailer']['username'],
        $container->get('config')['mailer']['password']
});

$container->set(IndexAction::class, function (Container $container) {
    return new IndexAction($container->get('db'), $container->get('per_page'));
});

$action = $container->get(IndexAction::class);