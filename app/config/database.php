<?php

return [
    'default' => [
        'connection_uri' => 'mysql:host=localhost;dbname='.env('MYSQL_DATABASE'),
        'username' => env('MYSQL_USERNAME'),
        'password' => env('MYSQL_PASSWORD'),
        'pdo_options' => [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'",
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    ]
];