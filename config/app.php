<?php

return [

	// Enable debug mode
	'debug' => false,

	// Path to the content folder
	'content_path' => BASE_PATH . 'content/',
	// The file extension to use for content files
	'content_extension' => '.md',

	// Path to the themes folder
	'themes_path' => BASE_PATH . 'public/themes/',
	// The currently active theme
	'theme' => 'baun',

	// The name of the folder where your posts are stored
	// (can be number prefixed but don't include that here)
	'blog_folder' => 'blog',
	// For blog pagination
	'posts_per_page' => 10,
	// The length of excerpts in words
	'excerpt_words' => 30,
	// The date format
	'date_format' => 'jS F Y',

	// Map the providers. Don't touch this
	// unless you know what you are doing
	'providers' => [
		'contentParser' => 'Baun\Providers\ContentParser',
		'events'        => 'Baun\Providers\Events',
		'router'        => 'Baun\Providers\Router',
		'theme'         => 'Baun\Providers\Theme'
	]

];