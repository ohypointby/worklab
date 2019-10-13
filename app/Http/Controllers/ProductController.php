<?php

namespace App\Http\Controllers;

require("vendor/autoload.php");
$openapi = \OpenApi\scan('/path/to/project');
header('Content-Type: application/x-yaml');
echo $openapi->toYaml();

use App\Http\Resources\DataResource;
use App\Http\Resources\ProductResource;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * @OA\Info(title="My First API", version="0.1")
     */

    /**
     * @OA\Get(
     *     path="/api/resource.json",
     *     @OA\Response(response="200", description="An example resource")
     * )
     */
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
     * Store a newly created resource in storage.
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        return ProductResource::collection(Product::where('id', $id)->get());
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
        $this->validate($request, [
            'name' =>'string|required',
            'category' => 'string|required'
        ]);

        return new ProductResource(Product::updateProduct($request, $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::unsetProduct($id);
    }

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
