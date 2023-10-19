<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UpdateProductTest extends TestCase
{
    use RefreshDatabase;

    public function testShouldCreateAProduct(): void
    {
        $product = Product::factory(1)->create()->first();
        $this->assertDatabaseCount('products', 1);
        Storage::fake('public');
        $bodyRequest = [
            'name' => 'foo',
            'price' => 2.34,
            'photo' => UploadedFile::fake()->image('product.jpg'),
        ];
        $response = $this->putJson('/api/products/' . $product->id, $bodyRequest);
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'price',
                    'photo',
                    'created_at',
                    'updated_at',
                ],
            ]);
        $this->assertDatabaseCount('products', 1);
        $this->assertDatabaseHas('products', [
            'name' => 'foo',
            'price' => 2.34,
        ]);
    }
}
