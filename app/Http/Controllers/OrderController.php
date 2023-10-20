<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddProductToOrderRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        return OrderResource::collection($orders);
    }

    public function show(Order $order)
    {
        return new OrderResource($order);
    }

    public function store(StoreOrderRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $validated = $request->validated();
            $order = Order::create(['customer_id' => $validated['customer_id']]);
            foreach ($validated['products'] as $productData) {
                $order->products()->attach($productData['product_id'], ['quantity' => $productData['quantity']]);
            }
            return new OrderResource($order);
        });
    }

    public function attachProduct(AddProductToOrderRequest $request, Order $order)
    {
        return DB::transaction(function () use ($request, $order) {
            $data = $request->validated();
            if ($order->products->contains($data['product_id'])) {
                $order->products()->updateExistingPivot($data['product_id'], ['quantity' => $data['quantity']]);
            } else {
                $order->products()->attach($data['product_id'], ['quantity' => $data['quantity']]);
            }
            return new OrderResource($order);
        });
    }

    public function detachProduct(Order $order, Product $product)
    {
        return DB::transaction(function () use ($order, $product) {
            $order->products()->detach($product->id);
            return response()->json("", 204);
        });
    }
}
