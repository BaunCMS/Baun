<?php namespace Baun\Interfaces;

interface Template {

	public function __construct($templates_path);

	public function render($template, $data = []);

}