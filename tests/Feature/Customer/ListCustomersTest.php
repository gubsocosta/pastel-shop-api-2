<?php

namespace Tests\Feature\Customer;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListCustomersTest extends TestCase
{
    use RefreshDatabase;

    public function testShouldGetAnEmptyCustomerList(): void
    {
        $this->assertDatabaseCount('customers', 0);
        $response = $this->get('/api/customers');
        $response
            ->assertStatus(200)
            ->assertJsonCount(0, 'data');

    }

    public function testShouldGetCustomerList(): void
    {
        Customer::factory(3)->create();
        $this->assertDatabaseCount('customers', 3);
        $response = $this->get('/api/customers');
        $response
            ->assertStatus(200)
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
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
                ],
            ]);
    }
}
