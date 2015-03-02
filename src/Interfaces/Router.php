<?php namespace Baun\Interfaces;

interface Router {

	public function add($method, $route, $function);

	public function dispatch();

}