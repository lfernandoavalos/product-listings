<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Src\Repositories\Eloquent\FavoriteRepository;

class FavoriteController extends Controller
{   

    /**
     * @var 
     */
    private $user;

    /**
     * @var FavoriteRepository
     */
    private $repo;

    /**
     * Description
     * @return type
     */
    public function __construct(FavoriteRepository $repo) {
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
        $user = $this->getAuthenticatedUser();
        return response()->json([
            'success' => true,
            'data' => $this->repo->fetchByUser($user->id)->toArray()
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
        $userId = $request->get('user_id');
        $productId = $request->get('product_id');

        //
        if(!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'user_id is a required field'
            ]);
        }

        if(!$productId) {
            return response()->json([
                'success' => false,
                'message' => 'product_id is a required field'
            ]);
        }

        try{
            $favorite = $this->repo->create([
                'user_id' => $userId,
                'product_id' => $productId
            ]);
        }catch(\Exception $e) {

        }

        return response()->json([
            'success' => true,
            'data' => $favorite->toArray()
        ]);
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
