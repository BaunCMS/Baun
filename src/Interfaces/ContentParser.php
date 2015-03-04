<?php namespace Baun\Interfaces;

interface ContentParser {

	/**
	 * Parses the file content and returns an array of data that
	 * is passed to the template provider.
	 *
	 * @param string $file_contents
	 * @return array data to pass to the template
	 */
	public function parse($file_contents);

}