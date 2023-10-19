<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ShowByIdProductTest extends TestCase
{
    use RefreshDatabase;

    public function testShouldReturnNotFound(): void
    {
        $this->assertDatabaseCount('products', 0);
        $response = $this->get('/api/products/1');
        $response
            ->assertStatus(404);
    }

    public function testShouldGetProductList(): void
    {
        $product = Product::factory(1)->create()->first();
        $this->assertDatabaseCount('products', 1);
        $response = $this->get('/api/products/' . $product->id);
        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'photo' => env('APP_URL') . Storage::url($product->photo),
                    'created_at' => $product->created_at->toISOString(),
                    'updated_at' => $product->updated_at->toISOString(),
                ]
            ], true);
    }
}
