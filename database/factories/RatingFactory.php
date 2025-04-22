<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rating>
 */
class RatingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'produce_id' => \App\Models\Produce::factory(),
            'buyer_id' => \App\Models\User::factory(),
            'stars' => $this->faker->numberBetween(1, 5),
            'comment' => $this->faker->sentence(),
        ];
    }
}
