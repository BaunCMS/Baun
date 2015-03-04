<?php

return [

	// Path to the content folder
	'content_path' => BASE_PATH . 'content/',
	// The file extension to use for content files
	'content_extension' => '.md',

	// Path to the themes folder
	'themes_path' => BASE_PATH . 'public/themes/',
	// The currently active theme
	'theme' => 'baun',

	// Map the providers. Don't touch this
	// unless you know what you are doing
	'providers' => [
		'contentParser' => 'Baun\Providers\ContentParser',
		'router'        => 'Baun\Providers\Router',
		'theme'         => 'Baun\Providers\Theme'
	]

];