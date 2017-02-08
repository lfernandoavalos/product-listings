<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Src\Scraper\ScraperFactory;

class SourceController extends Controller
{
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
        }catch(\Exception $e) {
            var_dump($e->getMessage());
            // TODO: Setup logging 
            return response()->json([
                'success' => false,
                'message' => "Looks like something went wrong"
            ]);
        }
        

        return response()->json([
            "success" => true,
            "message" => "$sourceName was successfully scrapped"
        ]);
    }

    /**
     * Scrape all sources
     *
     * @return \Illuminate\Http\Response
     */
    public function ascrape()
    {
        //
    }
}
