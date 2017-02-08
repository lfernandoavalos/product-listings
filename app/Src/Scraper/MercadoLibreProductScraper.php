<?php

namespace App\Src\Scraper;

use DOMDocument;
use DomXPath;
use App\Src\ValueObject\ProductValueObject;

// 
class MercadoLibreProductScraper extends AbstractScraper implements ProductScraperInterface
{

    const SOURCE_NAME = 'MERCADO_LIBRE';

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
        $this->url = $this->endpoint;
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
        $titleNode = $this->getNodes($this->dom, 'vip-section-header')->item(0);
        if (!$titleNode) {
            return null;
        }
        $titleNode = $this->getNodes($titleNode, 'vip-title-main')->item(0);
        return $titleNode->nodeValue;
    }

    /**
     * 
     * @return string
     */
    public function scrapeDescription() {
        $node = $this->getNodes($this->dom, 'item-description')->item(0);
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
        $priceNode = $this->getNodes($this->dom, 'vip-price')->item(0);
        if ( !$priceNode ) {
            return null;
        }
        
        $priceNode = $this->getTags($priceNode, 'strong')->item(0);
        $dom = $this->createDomDocument($priceNode);
        
        // we retrieve the chapter and remove it from the book
        $remove = $dom->getElementsByTagName('sup')->item(0);
        $decimal = $remove->nodeValue;
        
        $dom->getElementsByTagName('strong')->item(0)
            ->removeChild($dom->getElementsByTagName('sup')->item(0));
        
        $priceNode = $dom->getElementsByTagName('strong')->item(0);
        $price = $priceNode->nodeValue.".".$decimal;

        return $price;
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