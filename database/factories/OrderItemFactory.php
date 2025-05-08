<?php

namespace Database\Factories;

use App\Models\Produce;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    public function definition()
    {
        $produce = Produce::inRandomOrder()->first() ?? Produce::factory()->create();
        $quantity = $this->faker->numberBetween(1, 10);
        $unitPrice = $produce->price;
        $totalPrice = $quantity * $unitPrice;

        return [
            'produce_id' => $produce->id,
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'total_price' => $totalPrice,
            // order_id will be injected by OrderFactory
        ];
    }

    public function forProduce($produceId)
    {
        return $this->state([
            'produce_id' => $produceId,
        ]);
    }
}
