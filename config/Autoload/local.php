<?php
return [
    'auth'     => [
        'users' => [
            'admin' => 'password',
        ],
    ],
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'params' => [
                    'url' => 'sqlite::db/db.sqlite',
                ],
            ],
        ],
    ],
    'pdo' => [
        'dsn' => 'sqlite:db/db.sqlite',
        'username' => '',
        'password' => '',
    ],
];

