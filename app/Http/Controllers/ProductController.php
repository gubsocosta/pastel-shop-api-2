<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate();
        return ProductResource::collection($products);
    }

    public function show(Product $product): ProductResource
    {
        return new ProductResource($product);
    }

    public function store(StoreProductRequest $request): ProductResource
    {
        $validated = $request->validated();
        $product = new Product();
        $product->name = $validated['name'];
        $product->price = $validated['price'];
        $product->photo = $this->storePhoto($request);
        $product->save();
        return new ProductResource($product);
    }

    public function update(UpdateProductRequest $request, Product $product): ProductResource
    {
        $validated = $request->validated();
        $product->update($validated);
        return new ProductResource($product);
    }


    public function destroy(Product $product): JsonResponse
    {
        $result = $product->delete();
        if (!$result) {
            return response()->json(['message' => 'product not found.'], 404);
        }
        return response()->json("", 204);
    }

    private function storePhoto(Request $request): bool|JsonResponse|string
    {
        if (!$request->hasFile('photo')) {
            return response()->json("photo is required", 422);
        }
        $photo = $request->file('photo');
        $path = $photo->store('images/products', 'public');
        return $path;
    }
}
