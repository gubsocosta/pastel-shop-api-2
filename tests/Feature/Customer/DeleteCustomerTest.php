<?php

namespace Tests\Feature\Customer;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteCustomerTest extends TestCase
{
    use RefreshDatabase;

    public function testShouldCreateAProduct(): void
    {
        $customer = Customer::factory(1)->create()->first();
        $this->assertDatabaseCount('customers', 1);
        $response = $this->delete('/api/customers/' . $customer->id);
        $response->assertStatus(204);
        $this->assertSoftDeleted($customer);
    }
}
