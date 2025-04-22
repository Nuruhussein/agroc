<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PriceGuide>
 */
class PriceGuideFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category' => $this->faker->randomElement(['vegetable', 'fruit', 'grain']),
            'base_price' => $this->faker->randomFloat(2, 10, 200),
        ];
    }
}
