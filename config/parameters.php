<?php
return[
    'debug'    => true,
    'users'    => ['admin' => 'password'],
    'per_page' => 10,
    'address'  => 'ya@mail.ru',
    'db'       => [
        'dsn'      => 'mysql:localhost;dbname=courson',
        'username' => 'homestead',
        'password' => 'secret',
    ],
    'mailer'   => [
        'username' => 'root',
        'password' => 'secret',
    ],
];