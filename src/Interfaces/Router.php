<?php namespace Baun\Interfaces;

interface Router {

	/**
	 * Add a route to the router
	 *
	 * @param string $method GET/POST etc.
	 * @param string $route the route URI
	 * @param function $function route callback function
	 */
	public function add($method, $route, $function);

	/**
	 * Processes requests and dispatches the router
	 */
	public function dispatch();

	/**
	 * Get the URI of the current page
	 *
	 * @return string
	 */
	public function currentUri();

}