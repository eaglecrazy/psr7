<?php
return [
    'auth'  => [
        'users' => [
        'admin' => 'password'
        ],
    ],
    'pdo' => [
        'dsn'      => 'sqlite:db/db.sqlite',
        'username' => '',
        'password' => '',
    ],
    'phinx' => [
        'database' => 'db/db.sqlite',
    ],
];