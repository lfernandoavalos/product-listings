<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Src\Repositories\Eloquent\ProductRepository;

class ProductController extends Controller
{

    /**
     * @var ProductRepository
     */
    private $repo;

    /**
     * 
     * @param ProductRepository $repo 
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
    public function index(Request $request)
    {
        //
        $paginate = $request->get('show', 20);
        return response()->json([
            'success' => true,
            'data' => $this->repo->paginate($paginate)
        ]);
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
        $product = $this->repo->find($id);

        if(!$product) {
            return response()->json([
                'success' => false,
                'message' => "Could not find a product with id $id"
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $product->toArray()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
