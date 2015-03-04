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
			$this->template->render('404');
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

		$navigation = $this->filesToNav($files, $this->router->currentUri());
		$this->template->custom('baun_nav', $navigation);

		$routes = $this->filesToRoutes($files);
		foreach ($routes as $route) {
			$this->router->add('GET', $route['route'], function() use ($route) {
				$data = $this->getFileData($route['path']);
				$template = 'page';
				if (isset($data['info']['template']) && $data['info']['template']) {
					$template = $data['info']['template'];
				}

				return $this->template->render($template, $data);
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

	protected function filesToRoutes($files, $route_prefix = '', $path_prefix = '')
	{
		$result = [];

		foreach ($files as $key => $value) {
			if (!is_int($key)) {
				if (preg_match('/^\d+\-/', $key)) {
					list($index, $path) = explode('-', $key, 2);
					$result = array_merge($result, $this->filesToRoutes($value, $route_prefix . $path . '/', $path_prefix . $key . '/'));
				} else {
					$result = array_merge($result, $this->filesToRoutes($value, $route_prefix . $key . '/', $path_prefix . $key . '/'));
				}
			} else {
				$route = str_replace($this->config['content_extension'], '', $value['nice']);
				if ($route == 'index') {
					$route = '/';
				}

				$result[] = [
					'route' => $route_prefix . $route,
					'path' => $path_prefix . $value['raw']
				];
			}
		}

		return $result;
	}

	protected function filesToNav($files, $currentUri, $route_prefix = '', $path_prefix = '')
	{
		$result = [];

		foreach ($files as $key => $value) {
			if (!is_int($key)) {
				if (preg_match('/^\d+\-/', $key)) {
					list($index, $path) = explode('-', $key, 2);
					$result[$key] = $this->filesToNav($value, $currentUri, $route_prefix . $path . '/', $path_prefix . $key . '/');
				} else {
					$result[$key] = $this->filesToNav($value, $currentUri, $route_prefix . $key . '/', $path_prefix . $key . '/');
				}
			} else {
				$route = str_replace($this->config['content_extension'], '', $value['nice']);
				if ($route == 'index') {
					$route = '/';
				}
				if (!$currentUri) {
					$currentUri = '/';
				}

				$data = $this->getFileData($path_prefix . $value['raw']);
				$title = isset($data['info']['Title']) ? $data['info']['Title'] : '';
				if (!$title) {
					$title = ucwords(str_replace(['-', '_'], ' ', basename($route)));
				}
				$active = false;
				if ($route_prefix . $route == $currentUri) {
					$active = true;
				}

				if (!isset($data['info']['exclude_from_nav']) || !$data['info']['exclude_from_nav']) {
					$result[] = [
						'title'  => $title,
						'url'    => $route_prefix . $route,
						'active' => $active
					];
				}
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