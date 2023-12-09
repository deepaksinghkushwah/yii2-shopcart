<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=db;dbname=db',
    'username' => 'db',
    'password' => 'db',
    'charset' => 'utf8',
    // enable cache for db
    'enableSchemaCache' => false,
    // Duration of schema cache.
    'schemaCacheDuration' => 3600,
    // Name of the cache component used to store schema information
    'schemaCache' => 'cache',
];
