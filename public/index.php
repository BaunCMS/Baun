<?php

define('BASE_PATH', dirname(__DIR__) . '/');

if (file_exists(BASE_PATH . 'vendor/autoload.php')) {
	require BASE_PATH . 'vendor/autoload.php';

	$baun = new Baun\Baun();
	$baun->run();
} else {
	die('Missing vendor/autoload.php. Run <code>composer install</code>.');
}