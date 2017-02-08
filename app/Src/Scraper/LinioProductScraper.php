<?php

namespace App\Src\Scraper;

use DOMDocument;
use DomXPath;
use App\Src\ValueObject\ProductValueObject;

// 
class LinioProductScraper extends AbstractScraper implements ProductScraperInterface
{

    const SOURCE_NAME = 'LINIO';

    /**
     * @var string
     */
    private $productTitle;

    /**
     * @var string
     */
    private $productDescription;

    /**
     * @var App\Src\ValueObject\ProductValueObject
     */
    private $product;

    /**
     * Perform scraper setup
     */
    protected function setup() {
        $this->config = config('scrape.'.self::SOURCE_NAME);
    }

    /**
     * Build search endpoint url
     * 
     * @param string $productName
     * @return string
     */
    protected function constructSearchEndpoint() {
        $this->url = implode('', [
            $this->config['url'],
            $this->endpoint
        ]);
    }

    /**
     * 
     * @return \App\Src\ValueObject\ProductValueObject
     */
    public function getProduct() {
        return $this->product;
    }

    /**
     * 
     * @return string
     */
    public function scrapeTitle() {
        $titleNode = $this->getNodes($this->dom, 'product-title')->item(0);
        if ( !$titleNode ) {
            return null;
        }
        $titleH1 = $this->getTags($titleNode, 'h1')->item(0);
        $titleSpan = $this->getTags($titleH1, 'span')->item(0);
        return $titleSpan->nodeValue;
    }

    /**
     * 
     * @return string
     */
    public function scrapeDescription() {
        $node = $this->getNodes($this->dom, 'description-text-section')->item(0);
        if ( !$node ) {
            return null;
        }
        return $node->nodeValue;
    }

    /**
     * 
     * @return string
     */
    public function scrapePrice() {
        $priceNode = $this->getNodes($this->dom, 'price-main')->item(0);
        if ( !$priceNode ) {
            return null;
        }
        $price = preg_replace('/[^\d\.]/', '', $priceNode->nodeValue);
        return floatval($price);
    }

    /**
     * Run scraper to fetch products
     * 
     * @param string $productName
     * @return type
     */
    public function scrape() {
        $title = $this->scrapeTitle();            
        $description = $this->scrapeDescription();
        $price = $this->scrapePrice();

        $this->product = new ProductValueObject($title, $description, $price);
    }
}