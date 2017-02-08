<?php

namespace App\Src\ValueObject;

class ProductValueObject {

	private $title;
	private $description;
	private $price;

	private $source = "";

	/**
	 * 
	 * @param string $title 
	 * @param string $description 
	 * @param null $price 
	 * @return type
	 */
	public function __construct($title = '', $description = '', $price = null) {
		$this->title = trim($title);
		$this->description = trim($description);
		$this->price = $this->cleanPrice($price);
	}

	/**
	 * Clean/Format price
	 * @param string $price 
	 * @return float
	 */
	private function cleanPrice($price) {
		$price = preg_replace('/[^\d\.]/', '', $price);
        return floatval($price);
	}

	/**
	 * Source url
	 * @param string $source 
	 * @return void
	 */
	public function setSource($source) {
		$this->source = $source;
	}

	/**
	 * 
	 * @return array
	 */
	public function toArray() {
		return [
			'title' => $this->title,
			'description' => $this->description,
			'price' => $this->price,
			'source' => $this->source
		];
	}
}