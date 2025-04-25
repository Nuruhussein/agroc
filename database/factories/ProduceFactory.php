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
            'name' => 'Organic Cherry Tomatoes',
            'category_id' => \App\Models\Category::inRandomOrder()->first()->id ?? \App\Models\Category::factory(),
            'location' => 'California, USA',
            'farm_name' => 'Green Valley Farms',
            'description' => 'Sweet and juicy organic cherry tomatoes, perfect for salads and snacks. Grown with sustainable farming practices.',
            'price' => 4.99,
            'original_price' => 5.99,
            'discount' => 17,
            'organic' => true,
            'quantity' => $this->faker->numberBetween(10, 100),
            'image_path' => 'https://images.unsplash.com/photo-1587486913049-53fc88980cfc?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80',
        ];
    }
}
