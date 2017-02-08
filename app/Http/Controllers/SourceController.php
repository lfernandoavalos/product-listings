<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Src\Scraper\ScraperFactory;
use App\Src\Repositories\Eloquent\ProductRepository;

class SourceController extends Controller
{   
    /**
     * @var ProductRepository
     */
    private $repo;
    /**
     * 
     * @return type
     */
    public function __construct(ProductRepository $repo) {
        $this->repo = $repo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Scrape by source name
     * 
     * @param string $sourceName
     * @return \Illuminate\Http\Response
     */
    public function scrape(Request $request, $sourceName)
    {
        $product = trim($request->get('search'));
        $cproducts = [];
        if(!$product) {
            return response()->json([
                'success' => false,
                'message' => "search is a required field"
            ]);
        }
        
        //
        try{
            $scraper = ScraperFactory::create($sourceName, $product);
            $scraper->scrape();
            $products = $scraper->getProducts();
            foreach ($products as $product) {
                $cproducts[] = $this->repo->store($product)->toArray();
            }
        }catch(\Exception $e) {
            // TODO: Setup logging 
            error_log(print_r($e->getMessage(), 1));
            return response()->json([
                'success' => false,
                'message' => "Looks like something went wrong"
            ]);
        }
        

        return response()->json([
            "success" => true,
            'data' => $cproducts
        ]);
    }

    /**
     * Scrape all sources
     *
     * @return \Illuminate\Http\Response
     */
    public function ascrape(Request $request)
    {
        //
        $product = trim($request->get('search'));
        $products = [];
        $cproducts = [];

        if(!$product) {
            return response()->json([
                'success' => false,
                'message' => "search is a required field"
            ]);
        }

        $scrapers = array_keys(config('scrape'));

        foreach ($scrapers as $source) {            
            $scraper = ScraperFactory::create($source, $product);
            $scraper->scrape();
            $products = array_merge($scraper->getProducts(), $products);
        }

        foreach ($products as $product) {
            $cproducts[] = $this->repo->store($product)->toArray();
        }

        return response()->json([
            "success" => true,
            "data" => $cproducts
        ]);
    }
}
