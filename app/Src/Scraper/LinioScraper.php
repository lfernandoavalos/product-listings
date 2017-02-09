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
            error_log("$count => Doing some magic searching for a product $count > $this->limit");
            if ($count > $this->limit - 1) {
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
                $product->setSourceUrl($productScraper->getUrl());
                $product->setSource(self::SOURCE_NAME);
                $product->setTag($this->getTag());
                $this->products[] = $product;
            }
        }
    }
}