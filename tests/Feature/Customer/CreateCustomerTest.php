<?php

namespace Tests\Feature\Customer;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateCustomerTest extends TestCase
{
    use RefreshDatabase;

    public function testShouldCreateACustomer(): void
    {
        $this->assertDatabaseCount('customers', 0);
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
        $response = $this->postJson('/api/customers', $bodyRequest);
        $response->assertStatus(201)
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
