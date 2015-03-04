<?php namespace Baun\Interfaces;

interface Theme {

	public function __construct($themes_path);

	public function render($template, $data = []);

	public function custom($name, $data);

}