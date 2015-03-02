<?php namespace Baun\Providers;

use Baun\Interfaces\ContentParser as ContentParserInterface;
use Symfony\Component\Yaml\Parser;
use Michelf\MarkdownExtra;

class ContentParser implements ContentParserInterface {

	protected $parser;

	public function __construct()
	{
		$this->parser = new Parser();
	}

	public function parse($file_contents)
	{
		$data = [];
		$args = explode('----', $file_contents, 2);
		$header  = isset($args[0]) ? $args[0] : null;
		$content = isset($args[1]) ? $args[1] : null;

		if ($header) {
			try {
				$data['info'] = $this->parser->parse($header);
			} catch(\Exception $e) {}
		}
		if ($content) {
			try {
				$data['content'] = MarkdownExtra::defaultTransform($content);
			} catch(\Exception $e) {}
		}
		if (!isset($data['content'])) {
			$data['content'] = $file_contents;
		}

		return $data;
	}

}