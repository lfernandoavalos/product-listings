<?php

namespace App\Src\Scraper;

use DOMDocument;
use DomXPath;

// 
class LinioScraper extends AbstractScraper
{

    const SOURCE_NAME = 'LINIO';

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
        $pnodes = $this->getNodes($this->dom, 'detail-container');
        foreach ($pnodes as $count => $productContainerNode) {
            
            if ($count > $this->limit) {
                break;
            }

            $productNode = $this->getNodes($productContainerNode, 'title-section');
            foreach ($productNode as $node) {
                $tags = $this->getTags($node, 'a');
                $a = $tags->item(0);
                $href = $a->getAttribute('href');
                $productScraper = new LinioProductScraper($href);
                $productScraper->scrape();
                $product = $productScraper->getProduct();
                $product->setSource($productScraper->getUrl());
                $this->products[] = $product->toArray();
            }
        }
    }
}