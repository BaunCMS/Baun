<?php namespace Baun\Providers;

use Baun\Interfaces\Router as RouterInterface;
use Phroute\Phroute\RouteCollector;
use Phroute\Phroute\Dispatcher;

class Router implements RouterInterface {

	protected $router;

	public function __construct()
	{
		$this->router = new RouteCollector();
	}

	public function add($method, $route, $function)
	{
		$this->router->addRoute($method, $route, $function);
	}

	public function dispatch()
	{
		$dispatcher = new Dispatcher($this->router->getData());
		echo $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
	}

	public function currentUri()
	{
		return ltrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
	}

}