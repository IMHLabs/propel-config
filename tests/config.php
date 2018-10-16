<?php
declare(strict_types=1);

return [
    'database' => [
        'adapter' => 'pdo_mysql',
        'params'  => [
            'host'     => 'localhost',
            'username' => 'root',
            'password' => '',
            'dbname'   => 'test'
        ],
    ],
    //Propel Specific configutation Options
    'propel' => [
        'connections' => [
            'test'  => require __DIR__ . '\test.connection.config.php'
        ],
        'migrations' => [
            'test'  => require __DIR__ . '\test.migration.config.php'
        ],
    ],
];
