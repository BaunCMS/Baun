<?php

return [

	// Path to the content folder
	'content_path' => BASE_PATH . 'content/',
	// The file extension to use for content files
	'content_extension' => '.md',

	// Path to the templates folder
	'templates_path' => BASE_PATH . 'public/templates/',
	// The currently active template
	'template' => 'baun',

	// Map the providers. Don't touch this
	// unless you know what you are doing
	'providers' => [
		'contentParser' => 'Baun\Providers\ContentParser',
		'router'        => 'Baun\Providers\Router',
		'template'      => 'Baun\Providers\Template'
	]

];