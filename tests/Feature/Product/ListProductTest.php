<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListProductTest extends TestCase
{
    use RefreshDatabase;

    public function testShouldGetAnEmptyProductList(): void
    {
        $this->assertDatabaseCount('products', 0);
        $response = $this->get('/api/products');
        $response
            ->assertStatus(200)
            ->assertJsonCount(0, 'data');

    }

    public function testShouldGetProductList(): void
    {
        Product::factory(3)->create();
        $this->assertDatabaseCount('products', 3);
        $response = $this->get('/api/products');
        $response
            ->assertStatus(200)
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'price',
                        'photo',
                        'created_at',
                        'updated_at',
                    ],
                ],
            ]);
    }
}
