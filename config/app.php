<?php

return [

	'content_path' => BASE_PATH . 'content/',
	'content_extension' => '.md',

	'templates_path' => BASE_PATH . 'public/templates/',
	'template' => 'baun',

	'providers' => [
		'contentParser' => 'Baun\Providers\ContentParser',
		'router'        => 'Baun\Providers\Router',
		'template'      => 'Baun\Providers\Template'
	]

];