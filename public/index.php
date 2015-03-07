<?php

define('BASE_PATH', dirname(__DIR__) . '/');

if (file_exists(BASE_PATH . 'vendor/autoload.php')) {
	require BASE_PATH . 'vendor/autoload.php';

	$baun = new Baun\Baun();
	$baun->run();
} else {
	if (file_exists(BASE_PATH . 'auto-install.php')) {
		require BASE_PATH . 'auto-install.php';
	} else {
		die('Missing vendor/autoload.php. Run <code>composer install</code>.');
	}
}