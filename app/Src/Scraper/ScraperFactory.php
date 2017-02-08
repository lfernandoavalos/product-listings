<?php

namespace App\Src\Scraper;

class ScraperFactory {

	/**
	 * Create new scraper
	 * @param string $sourceName
	 */
	static public function create($name, $endpoint) {
		$words = explode('_', $name);
		$name = '';
		foreach ($words as $w) {
			$name .= ucwords(strtolower($w));
		}		

		$class = "\App\Src\Scraper\\".$name.'Scraper';

		if ( !class_exists($class) ) {
			throw new \Exception("$class not found", 1);
		}

		$instance = new $class($endpoint);
		$instance->setTag($endpoint);
		return $instance;
	}
}