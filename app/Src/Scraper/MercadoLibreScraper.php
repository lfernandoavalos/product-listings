<?php

namespace App\Src\Scraper;

use DOMDocument;
use DomXPath;

// 
class MercadoLibreScraper extends AbstractScraper
{

    const SOURCE_NAME = 'MERCADO_LIBRE';

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
            $this->config['products_search_endpoint'],
            $this->endpoint
        ]);

    }



    /**
     * Run scraper to fetch products
     * 
     * @param string $productName
     * @return type
     */
    public function scrape() {

        $pnodes = $this->getNodes($this->dom, 'item-link');
        
        foreach ($pnodes as $count => $a) {
            
            if ($count > $this->limit) {
                break;
            }
            $href = $a->getAttribute('href');
            $productScraper = new MercadoLibreProductScraper($href);
            $productScraper->scrape();
            $product = $productScraper->getProduct();
            $product->setSourceUrl($productScraper->getUrl());
            $product->setSource(self::SOURCE_NAME);
            $product->setTag($this->getTag());
            $this->products[] = $product->toArray();
        }
    }
}