<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::paginate();
        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $validated = $request->validate([
            'name' => 'required|alpha|min:3',
            'price' => 'required|decimal:2|gte:0',
            'photoUrl' => 'required|url:http,https'
        ]);
        $product = Product::create($validated);
        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|alpha|min:3',
            'price' => 'required|decimal:2|gte:0',
            'photoUrl' => 'required|url:http,https'
        ]);
        $product->update($validated);
        return new ProductResource($product)
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
