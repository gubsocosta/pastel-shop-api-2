<?php

namespace Tests\Feature\Product;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CreateProductTest extends TestCase
{
    use RefreshDatabase;

    public function testShouldCreateAProduct(): void
    {
        $this->assertDatabaseCount('products', 0);
        Storage::fake('public');
        $bodyRequest = [
            'name' => 'foo',
            'price' => 2.34,
            'photo' => UploadedFile::fake()->image('product.jpg'),
        ];
        $response = $this->postJson('/api/products', $bodyRequest);
        $response->assertStatus(201)
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
