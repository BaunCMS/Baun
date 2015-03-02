<?php namespace Baun;

class Baun {

	protected $config;
	protected $router;
	protected $template;
	protected $contentParser;

	public function __construct()
	{
		if (!file_exists(BASE_PATH . 'config/app.php')) {
			die('Missing config/app.php');
		}
		$this->config = require BASE_PATH . 'config/app.php';

		// Router
		if (!isset($this->config['providers']['router']) || !class_exists($this->config['providers']['router'])) {
			die('Missing router provider');
		}
		$this->router = new $this->config['providers']['router'];

		// Template
		if (!isset($this->config['providers']['template'])){
			die('Missing template provider');
		}
		if (!isset($this->config['templates_path'])) {
			die('Missing templates path');
		}
		if (!isset($this->config['template']) || !is_dir($this->config['templates_path'] . $this->config['template'])) {
			die('Missing template');
		}
		$this->template = new $this->config['providers']['template']($this->config['templates_path'] . $this->config['template']);

		// Content Parser
		if (!isset($this->config['providers']['contentParser'])){
			die('Missing content parser');
		}
		$this->contentParser = new $this->config['providers']['contentParser'];

		// Run
		$this->setupRoutes();
		$this->router->dispatch();
	}

	protected function setupRoutes()
	{
		$files = $this->getContentFiles();
		foreach ($files as $file) {
			$route = str_replace('content/', '', $file);
			$route = str_replace($this->config['content_extension'], '', $route);

			if ($route != '404') {
				if ($route == 'index') $route = '/';

				$this->router->add('GET', $route, function() use ($file) {
					$data = $this->getFileData($file);
					return $this->template->render('content.html', $data);
				});
			}
		}
	}

	protected function getFileData($file_path)
	{
		$file_path = BASE_PATH . $file_path;
		$file_contents = file_get_contents($file_path);
		return $this->contentParser->parse($file_contents);
	}

	protected function getContentFiles()
	{
		if (!isset($this->config['content_path']) || !is_dir($this->config['content_path'])) {
			die('Missing content path');
		}
		if (!isset($this->config['content_extension'])) {
			die('Missing content extension');
		}

		$Directory = new \RecursiveDirectoryIterator($this->config['content_path']);
		$Iterator = new \RecursiveIteratorIterator($Directory);
		$Regex = new \RegexIterator($Iterator, '/^.+\\'. $this->config['content_extension'] .'$/i', \RecursiveRegexIterator::GET_MATCH);
		$files = array_keys(iterator_to_array($Regex));

		foreach ($files as $key => $file) {
			$files[$key] = str_replace(BASE_PATH, '', $file);
		}

		return $files;
	}

}