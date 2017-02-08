<?php

namespace App\Src\Scraper;

use DOMDocument;
use DomXPath;
use DOMNodeList;
use DOMElement;

// 
abstract class AbstractScraper
{
    /**
     * @var array $config
     */
    protected $config;

    /**
     * @var string $url
     */
    protected $url;

    /**
     * @var \DOMDocument
     */
    protected $dom;

    /**
     * @var string
     */
    protected $productName;

    /**
     * @var array
     */
    protected $products = [];

    /**
     * @var int
     */
    protected $limit = 2;

    /**
     * Constructor
     * @return 
     */
    public function __construct($endpoint = null) {
        //
        $this->endpoint = $endpoint;
        // 
        $this->dom = new DOMDocument();
        // construct base url
        $this->setup();
        // construct search endpoint
        $this->constructSearchEndpoint();
        // Load html
        $this->setDomDocumentUrl();
    }

    public function createDomDocument($dom) {
        $html = $dom->ownerDocument->saveHTML($dom);
        $dom = new DOMDocument;
        @$dom->loadHTML($html);
        return $dom;
    }

    /**
     * Description
     * @param DOMDocument $dom 
     * @param string $tag 
     * @return type
     */
    protected function getTags($dom, $tag) {
        if ( !($dom instanceof DOMDocument) ) {
            $dom = $this->createDomDocument($dom);  
        }
        
        return $dom->getElementsByTagName($tag);
    }

    /**
     * Retrieve nodes by classname
     * 
     * @param \DOMDocument $dom
     * @param string $className 
     * @return DOMNodeList
     */
    protected function getNodes($dom, $classname) {
        if ( !($dom instanceof DOMDocument))  {
            $dom = $this->createDomDocument($dom);
        }

        $finder = new DomXPath($dom);
        return $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");
    }

    /**
     * 
     * @return type
     */
    protected function setDomDocumentUrl() {
        @$this->dom->loadHTMLFile($this->url);
    }

    /**
     * Get scraper url
     * @return type
     */
    public function getUrl() {
        return $this->url;
    }

    /**
     * Let children perform setup
     */
    abstract protected function setup();

    /**
     * Product name to scrape
     * @return array
     */
    abstract public function scrape();

    /**
     * Retrieve products
     * @return type
     */
    public function getProducts() {
        return $this->products;
    }

    /**
     * Create search endpoint
     * @return
     */
    abstract protected function constructSearchEndpoint();
}

