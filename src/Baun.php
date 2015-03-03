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
	}

	public function run()
	{
		$this->setupRoutes();

		try {
			$this->router->dispatch();
		} catch(\Exception $e) {
			$this->template->render('404.html');
		}
	}

	protected function setupRoutes()
	{
		if (!isset($this->config['content_path']) || !is_dir($this->config['content_path'])) {
			die('Missing content path');
		}
		if (!isset($this->config['content_extension'])) {
			die('Missing content extension');
		}

		$files = $this->getFiles($this->config['content_path'], $this->config['content_extension']);
		$routes = $this->filesToRoutes($files);
		$navigation = $this->filesToNav($files);
		foreach ($routes as $route) {
			$this->router->add('GET', $route['route'], function() use ($navigation, $route) {
				$data = $this->getFileData($route['path']);
				$data['navigation'] = $navigation;
				return $this->template->render('template.html', $data);
			});
		}
	}

	protected function getFiles($dir, $extension, $top = true)
	{
		$result = [];
		$dirs = [];
		$files = [];
		$sdir = scandir($dir);

		foreach ($sdir as $key => $value) {
			if (!in_array($value,array('.','..'))) {
				$ext = pathinfo($value, PATHINFO_EXTENSION);
				if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) {
					$dirs[$value] = $this->getFiles($dir . DIRECTORY_SEPARATOR . $value, $extension, false);
				} elseif('.' . $ext == $extension) {
					if (preg_match('/^\d+\-/', $value)) {
						list($index, $path) = explode('-', $value, 2);
						$files[$index] = [
							'nice' => $path,
							'raw' => $value
						];
					} else {
						$files[] = [
							'nice' => $value,
							'raw' => $value
						];
					}
				}
			}
		}

		ksort($dirs);
		ksort($files);
		if ($top) {
			$result = array_merge($files, $dirs);
		} else {
			$result = array_merge($dirs, $files);
		}

		return $result;
	}

	protected function filesToRoutes($files, $prefix = '')
	{
		$result = [];

		foreach ($files as $key => $value) {
			if (!is_int($key)) {
				$result = array_merge($result, $this->filesToRoutes($value, $prefix . $key . '/'));
			} else {
				$route = str_replace($this->config['content_extension'], '', $value['nice']);
				if ($route == 'index') {
					$route = '/';
				}

				$result[] = [
					'route' => $prefix . $route,
					'path' => $prefix . $value['raw']
				];
			}
		}

		return $result;
	}

	protected function filesToNav($files, $prefix = '')
	{
		$result = [];

		foreach ($files as $key => $value) {
			if (!is_int($key)) {
				$result[] = $this->filesToNav($value, $prefix . $key . '/');
			} else {
				$route = str_replace($this->config['content_extension'], '', $value['nice']);
				if ($route == 'index') {
					$route = '/';
				}

				$data = $this->getFileData($prefix . $value['raw']);
				$title = isset($data['info']['Title']) ? $data['info']['Title'] : '';
				if (!$title) {
					$title = ucwords(str_replace(['-', '_'], ' ', basename($route)));
				}

				$result[] = [
					'title' => $title,
					'url' => $prefix . $route
				];
			}
		}

		return $result;
	}

	protected function getFileData($route_path)
	{
		$file_path = $this->config['content_path'] . $route_path;
		$file_contents = file_get_contents($file_path);
		return $this->contentParser->parse($file_contents);
	}

}