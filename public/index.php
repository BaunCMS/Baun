<?php

define('BASE_PATH', dirname(__DIR__) . '/');

require BASE_PATH . 'vendor/autoload.php';

$baun = new Baun\Baun();
$baun->run();