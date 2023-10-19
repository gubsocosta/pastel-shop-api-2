<?php

namespace Tests\Feature\Customer;

use App\Models\Customer;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UpdateCustomerTest extends TestCase
{
    use RefreshDatabase;

    public function testShouldCreateAProduct(): void
    {
        $customer = Customer::factory(1)->create()->first();
        $this->assertDatabaseCount('customers', 1);
        Storage::fake('public');
        $bodyRequest = [
            'name' => 'John Doe',
            'email' => 'j@jd.com',
            'phone_number' => '31988888888',
            'date_of_birth' => '1991-02-09',
            'address' => 'Customer street',
            'complement' => 'Customer complement',
            'neighborhood' => 'Customer neighborhood',
            'zipcode' => '35180000'
        ];
        $response = $this->putJson('/api/customers/' . $customer->id, $bodyRequest);
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'phone_number',
                    'date_of_birth',
                    'address',
                    'complement',
                    'neighborhood',
                    'zipcode',
                    'created_at',
                    'updated_at'
                ],
            ]);
        $this->assertDatabaseCount('customers', 1);
        $this->assertDatabaseHas('customers', $bodyRequest);
    }
}
