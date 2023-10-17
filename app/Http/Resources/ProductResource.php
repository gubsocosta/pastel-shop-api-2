<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (int)$this->id,
            'name' => $this->name,
            'price' => (float)$this->price,
            'photo' => env('APP_URL') . Storage::url($this->photo),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
