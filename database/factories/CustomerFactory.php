<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->email(),
            'phone_number' => fake()->numerify('###########'),
            'date_of_birth' => fake()->date("Y-m-d"),
            'address' => fake()->streetAddress(),
            'complement' => fake()->sentence(2),
            'neighborhood' => fake()->sentence(1),
            'zipcode' => fake()->numerify('########'),
        ];
    }
}
