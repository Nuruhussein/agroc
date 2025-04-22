<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produce>
 */
class ProduceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'name' => $this->faker->word(),
            // 'category' => $this->faker->randomElement(['vegetable', 'fruit', 'grain']),
            'category_id' => \App\Models\Category::inRandomOrder()->first()->id ?? \App\Models\Category::factory(),

            'price' => $this->faker->randomFloat(2, 5, 100),
            'quantity' => $this->faker->numberBetween(1, 50),
            'image_path' => 'produce.jpg',
        ];
    }
}
