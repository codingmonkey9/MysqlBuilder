<?php

// this is only a configure for mysql db now.

$db = [
	'dbname' => 'count',
	'host' => 'localhost',
	'driver' => 'mysql',  //prepare for supporting variable db types later.
	'user' => 'root',
	'pass' => 'root',
];
return $db;