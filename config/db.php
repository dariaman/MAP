<?php

return [
    'class' => 'yii\db\Connection',
    // 'dsn' => 'sqlsrv:server=10.10.10.245;database=MAPIS2',
    // 'username' => 'dariaman',
    // 'password' => 'P@ssw0rd',

    // 'dsn' => 'sqlsrv:server=192.168.56.101;database=MAPIS;MultipleActiveResultSets=true',
    // 'username' => 'dariaman',
    // 'password' => 'P@ssw0rd',

    // 'dsn' => 'sqlsrv:server=192.168.200.117;database=MAPISdev',
    // 'username' => 'sa',
    // 'password' => 'D@r!aman46',

    'dsn' => 'sqlsrv:server=192.168.200.117;database=MAPIS',
    'username' => 'sa',
    'password' => 'D@r!aman46',

	'enableSchemaCache' => true,
	// Name of the cache component used to store schema information
	'schemaCache' => 'cache',
	// Duration of schema cache.
	'schemaCacheDuration' => 86400, // 24H it is in seconds
    'charset' => 'utf8', 
];