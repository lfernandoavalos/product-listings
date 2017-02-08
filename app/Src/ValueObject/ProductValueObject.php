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
		$this->title = $title;
		$this->description = $description;
		$this->price = $price;
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