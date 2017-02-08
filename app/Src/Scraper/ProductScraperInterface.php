<?php

namespace App\Src\Scraper;

interface ProductScraperInterface
{	
	/**
	 * 
	 * @return type
	 */
	public function scrapeTitle();

	/**
	 * 
	 * @return type
	 */
	public function scrapeDescription();

	/**
	 * 
	 * @return type
	 */
	public function scrapePrice();
}