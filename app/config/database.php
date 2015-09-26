<?php

return [
    'default' => [
        'connection_uri' => 'mysql:host=localhost;dbname=test',
        'username' => 'svetlin',
        'password' => 'qwerty',
        'pdo_options' => [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'",
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    ]
];