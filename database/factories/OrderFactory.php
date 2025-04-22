<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'buyer_id' => \App\Models\User::factory(),
            'produce_id' => \App\Models\Produce::factory(),
            'quantity' => $this->faker->numberBetween(1, 10),
            'status' => 'pending',
            'delivery_status' => 'pending',
        ];
    }
}
