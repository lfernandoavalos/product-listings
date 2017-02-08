<?php

namespace App\Src\ValueObject;

class ProductValueObject {

	private $title;
	private $description;
	private $price;

	private $source = "";
	private $tag = "";
	private $sourceUrl = "";

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
	public function setSourceUrl($sourceUrl) {
		$this->sourceUrl = $sourceUrl;
	}

	/**
	 * Source 
	 * @param string $source 
	 * @return void
	 */
	public function setSource($source) {
		$this->source = $source;
	}

	/**
	 * Set tag 
	 * @param string $tag 
	 * @return void
	 */
	public function setTag($tag) {
		$this->tag = $tag;
	}

	/**
	 * 
	 * @return type
	 */
	public function getTag() {
		return $this->tag;
	}

	/**
	 * 
	 * @return string
	 */
	public function getSourceUrl() {
		return $this->sourceUrl;
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
			'source_url' => $this->sourceUrl,
			'source' => $this->source,
			'tag' => $this->tag
		];
	}
}