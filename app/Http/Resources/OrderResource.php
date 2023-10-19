<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'customer' => [
                'id' => $this->customer->id,
                'name' => $this->customer->name,
                'email' => $this->customer->email,
                'phone_number' => $this->customer->phone_number,
                'date_of_birth' => $this->customer->date_of_birth,
                'complement' => $this->customer->complement,
                'address' => $this->customer->address,
                'neighborhood' => $this->customer->neighborhood,
                'zipcode' => $this->customer->zipcode,
            ],
            'products' => $this->products->map(function ($product) {
                return [
                    'id' => (int)$product->id,
                    'name' => $product->name,
                    'price' => (float)$product->price,
                    'photo' => env('APP_URL') . Storage::url($product->photo),
                    'quantity' => (int)$product->pivot->quantity
                ];
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
