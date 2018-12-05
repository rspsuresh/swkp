<?php

// This is the database connection configuration.
return array(
	//'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
	// uncomment the following lines to use a MySQL database

	'connectionString' => 'mysql:host=localhost;dbname=kpws_223',
//	'connectionString' => 'mysql:host=192.168.15.20;dbname=paror_yii',
	'emulatePrepare' => true,
	'username' => 'root',
	'password' => 'test',
	'charset' => 'utf8',
	
);