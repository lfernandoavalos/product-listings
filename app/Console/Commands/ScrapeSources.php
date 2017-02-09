<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Src\Scraper\ScraperFactory;

class ScrapeSources extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:sources {search} {--limit=20} {--source=defaults}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $product = $this->argument('search');
        $products = [];

        $limit = $this->option('limit');
        $source = $this->option('source');
        $sources = [];
        if($source == 'defaults') {
            $sources = array_keys(config('scrape'));
        } else {
            $sources[] = $source;
        }

        foreach ($sources as $source) {            
            $scraper = ScraperFactory::create($source, $product);
            $scraper->setLimit($limit);
            $scraper->scrape();
            $products = array_merge($scraper->getProducts(), $products);
        }

    }
}
