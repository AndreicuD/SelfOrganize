<?php

return [
    'class' => \yii\db\Connection::class,
    'dsn' => 'mysql:host=db;dbname=db;port=3306',
    'username' => 'db',
    'password' => 'db',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
