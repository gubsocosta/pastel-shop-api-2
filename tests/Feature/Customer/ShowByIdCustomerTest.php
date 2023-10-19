<?php

namespace Tests\Feature\Customer;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowByIdCustomerTest extends TestCase
{
    use RefreshDatabase;

    public function testShouldReturnNotFound(): void
    {
        $this->assertDatabaseCount('customers', 0);
        $response = $this->get('/api/customers/1');
        $response
            ->assertStatus(404);
    }

    public function testShouldGetProductList(): void
    {
        $customer = Customer::factory(1)->create()->first();
        $this->assertDatabaseCount('customers', 1);
        $response = $this->get('/api/customers/' . $customer->id);
        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $customer->id,
                    'name' => $customer->name,
                    'email' => $customer->email,
                    'phone_number' => $customer->phone_number,
                    'date_of_birth' => $customer->date_of_birth,
                    'address' => $customer->address,
                    'complement' => $customer->complement,
                    'neighborhood' => $customer->neighborhood,
                    'zipcode' => $customer->zipcode,
                    'created_at' => $customer->created_at->toISOString(),
                    'updated_at' => $customer->updated_at->toISOString(),
                ]
            ], true);
    }
}
