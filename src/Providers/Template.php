<?php namespace Baun\Providers;

use Baun\Interfaces\Template as TemplateInterface;

class Template implements TemplateInterface {

	protected $template;

	public function __construct($templates_path)
	{
		$loader = new \Twig_Loader_Filesystem($templates_path);
		$this->template = new \Twig_Environment($loader);
	}

	public function render($template, $data = [])
	{
		echo $this->template->render($template, $data);
	}

}