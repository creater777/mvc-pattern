<?php
return [
    'WebRoot' => APP_ROOT.'/web',
    'HTTPRoot' => '/web',
    'debug' => false,
    'DB' => [
        'provider' => 'Lib\DB\MySql',
        'host' => 'localhost',
        'database' => 'test',
        'user' => 'root',
        'password' => 'root'
    ]
];