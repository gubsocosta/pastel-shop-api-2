<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteProductTest extends TestCase
{
    use RefreshDatabase;

    public function testShouldCreateAProduct(): void
    {
        $product = Product::factory(1)->create()->first();
        $this->assertDatabaseCount('products', 1);
        $response = $this->delete('/api/products/' . $product->id);
        $response->assertStatus(204);
        $this->assertSoftDeleted($product);
    }
}
