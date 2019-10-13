<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware('cors')->group(function () {
    Route::get('categories', 'CategoryController@index');
    Route::get('categories/{category}/products', 'CategoryController@products');
    Route::get('products/{id}', 'ProductController@show');
    Route::post('register','UserController@store');
    Route::get('modified', 'ProductController@showModifiedProducts');

    Route::middleware('auth:api')->group(function () {
        Route::post('products', 'ProductController@store');
        Route::put('products/{id}', 'ProductController@update');
        Route::delete('products/{id}', 'ProductController@destroy');
    });

});
