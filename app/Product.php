<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Product extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'code', 'price', 'availability', 'brand', 'description',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'update_at', 'deleted_at'
    ];

    /**
     * Belongs-to-many communication with categories.
     *
     * @return belongsToMany
     */
    public function categories() {
        return $this->belongsToMany('App\Category');
    }

    /**
     * Product creation.
     *
     * @param Request $request
     * @return Product
     */
    public static function setProduct(Request $request) {

        $data = $request->only([
            'name',
        ]);

        $product = new Product($data);
        $product->save();

        if ($request->has('category') && $category = Category::where('name', $request['category'])->firstOrFail()->id) {
            $product->categories()->attach(['category_id' => $category]);
        }
        return $product;
    }

    /**
     * Product change.
     *
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public static function updateProduct(Request $request, $id) {

        $product = Product::where('id', $id)->firstOrFail();

        $data = $request->only([
            'name',
        ]);

        $product->update($data);

        if ($request->has('category') && $category = Category::where('name', $request['category'])->firstOrFail()->id) {
            $product->categories()->detach();
            $product->categories()->attach(['category_id' => $category]);
        }

        return $product;
    }

    /**
     * Product removal.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public static function unsetProduct($id) {

        $product = Product::find($id);

        if ($product->categories)
            $product->categories()->detach();

        $product->delete();

        return response()->json(['Successfully deleted'], 204);
    }

    /**
     * Search for modified products.
     *
     * @param $time
     * @return array
     */
    public static function findModifiedProducts($time) {

        $now = Carbon::now();

        $product_result = array();

        foreach ($products = Product::all() as $product) {
            if ($now->diffInMinutes($product->updated_at) <= $time) {
                $product_result[] = $product;
            }
        }

        return $product_result;
    }

}
