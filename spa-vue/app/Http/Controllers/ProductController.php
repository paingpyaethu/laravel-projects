<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        return Product::when(request('search'), function ($query){
           $query->where('name', 'like', '%'.request('search').'%');
        })->orderBy('id', 'desc')->get();
    }

    public function store(ProductStoreRequest $request)
    {
         return Product::create($request->only('name', 'price'));
    }

    public function show(Product $product)
    {
        return $product;
    }

    public function update(ProductUpdateRequest $request, Product $product)
    {
        return $product->update($request->only('name', 'price'));
    }

    public function destroy(Product $product)
    {
        return $product->delete();
    }
}
