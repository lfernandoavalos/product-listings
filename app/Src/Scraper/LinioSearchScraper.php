<?php

namespace App\Src\Scraper;

class LinioSearchScraper {

	/**
	 * @var 
	 */
	private $perPage = 60;
	private $limit;
	private $products = [];
	private $tag = "";

	/**
	 * 
	 */
	public function __construct($endpoint) {
		$this->endpoint = $endpoint;
	}
	
	/**
	 * 
	 */
	public function setLimit($limit) {
		$this->limit = $limit;
	}

	/**
	 * 
	 * @param type $tag 
	 * @return type
	 */
	public function setTag($tag) {
		$this->tag = $tag;
	}

	/**
	 * 
	 */
	public function scrape() {
		$pages = ceil($this->limit/$this->perPage);
		$scrapers = [];
		$total = 0;
		error_log("Pages $pages");
		for ($i=0; $i < $pages; $i++) { 
			if ($i == 0) {
				error_log($this->endpoint);
				$scraper = new LinioScraper($this->endpoint);
				if($this->limit > $this->perPage) {
            		$limit = $this->perPage;
				} else {
					$limit = $this->limit;
				}
			} else {
				$endpoint = $this->endpoint."&page=".($i + 1);
				error_log($endpoint);
				$scraper = new LinioScraper($endpoint);
				$limit = ($this->limit - $total);
			}

			$scraper->setLimit($limit);
			$scraper->setTag($this->tag);
            $scraper->scrape();
            error_log("Total products in scraper => ".sizeof($scraper->getProducts()));
            $this->products = array_merge($this->products, $scraper->getProducts());
			error_log("Has ".sizeof($this->products));

            if ($i == 0)
            	$total += $this->perPage;
            else
            	$total += $limit;
		}
	}

	/**
	 * 
	 */
	public function getProducts() {
		return $this->products;
	}

}