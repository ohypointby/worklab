<?php

namespace App\Http\Controllers;

use App\Http\Resources\DataResource;
use App\Http\Resources\ProductResource;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    /**
     * Display a listing of the product.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new product.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    /**
     * @OA\Post(
     *     path="/api/products",
     *     summary="Store a newly created product in storage",
     *     @OA\Response(response="200", description="OK")
     * )
     */
    /**
     * Store a newly created product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' =>'string|required',
            'category' => 'string|required'
        ]);

        return new ProductResource(Product::setProduct($request));
    }

    /**
     * @OA\Get(
     *     path="/api/products/{id}",
     *     summary="Display the specified product",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id of product",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *     @OA\Response(response="200", description="OK")
     * )
     */
    /**
     * Display the specified product.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        return ProductResource::collection(Product::where('id', $id)->get());
    }

    /**
     * Show the form for editing the specified product.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * @OA\Put(
     *     path="/api/products/{id}",
     *     summary="Update the specified product in storage",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id of product",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *     @OA\Response(response="200", description="OK")
     * )
     */
    /**
     * Update the specified product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' =>'string|required',
            'category' => 'string|required'
        ]);

        return new ProductResource(Product::updateProduct($request, $id));
    }

    /**
     * @OA\Delete(
     *     path="/api/products/{id}",
     *     summary="Remove the specified product from storage",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id of modified",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *     @OA\Response(response="200", description="OK")
     * )
     */
    /**
     * Remove the specified product from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::unsetProduct($id);
    }

    /**
     * @OA\Get(
     *     path="/api/modified",
     *     @OA\Parameter(
     *         name="time",
     *         in="query",
     *         description="Time of modified",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *     @OA\Response(response="200", description="OK")
     * )
     */
    /**
     * Search for modified products.
     *
     * @param Request $request
     * @return DataResource
     */
    public function showModifiedProducts(Request $request)
    {
        $time = $request['time'];

        return new DataResource(Product::findModifiedProducts($time));
    }
}
