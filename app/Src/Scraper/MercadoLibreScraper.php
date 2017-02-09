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
        if($this->limit <= $pnodes->length) {

        }
        foreach ($pnodes as $count => $productContainerNode) {
            error_log("$count => Doing some magic searching for a product $count > $this->limit");
            if ($count > $this->limit - 1) {
                break;
            }

            $productNode = $this->getNodes($productContainerNode, 'item-link')->item(0);
            $tags = $this->getTags($productNode, 'a');
            $a = $tags->item(0);
            $href = $a->getAttribute('href');
            // TODO:: Look into 'click1' links
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