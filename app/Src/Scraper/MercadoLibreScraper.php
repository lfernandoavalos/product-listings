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

        $pnodes = $this->getNodes($this->dom, 'rowItem');
        
        foreach ($pnodes as $count => $productContainerNode) {
            
            if ($count > $this->limit) {
                break;
            }

            $productNode = $this->getNodes($productContainerNode, 'item-link')->item(0);
            $tags = $this->getTags($productNode, 'a');
            $a = $tags->item(0);
            $href = $a->getAttribute('href');
            if(preg_match('/click1/', $href)) {
                continue;
            }
            $productScraper = new MercadoLibreProductScraper($href);
            $productScraper->scrape();
            $product = $productScraper->getProduct();
            $product->setSourceUrl($productScraper->getUrl());
            $product->setSource(self::SOURCE_NAME);
            $product->setTag($this->getTag());
            $this->products[] = $product;
        }
    }
}