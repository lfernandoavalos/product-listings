<?php

namespace App\Src\Scraper;

class ScraperFactory {

	/**
	 * Create new scraper
	 * @param string $sourceName
	 */
	static public function create($name, $endpoint) {
		$name = ucwords(strtolower($name));
		$class = "\App\Src\Scraper\\".$name.'Scraper';
		if ( !class_exists($class) ) {
			throw new \Exception("$class not found", 1);
		}
		return new $class($endpoint);
	}
}