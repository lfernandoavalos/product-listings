<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Src\Scraper\ScraperFactory;
use App\Src\Repositories\Eloquent\ProductRepository;

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

        $this->repo = app('\App\Src\Repositories\Eloquent\ProductRepository');
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
            try{
                $scraper = ScraperFactory::create($source, $product);
                $scraper->setLimit($limit);
                $scraper->setTag($product);
                $scraper->scrape();
                $products = array_merge($scraper->getProducts(), $products);    
            }catch(\Exception $e) {
                $this->error("Config for $source was not found");
            }   
        }

        foreach ($products as $c => $product) {
            error_log("$c => Adding ".$product->getTitle());
            $this->repo->store($product)->toArray();    
        }

        $this->info(sizeof($products)." were added to the database");
    }
}
