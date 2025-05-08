<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    public function definition()
    {
        return [
            'buyer_id' => User::factory()->create(['role' => 'buyer'])->id,
            'order_number' => 'ORD-' . now()->format('Ymd') . '-' . strtoupper(uniqid()),
            'total_amount' => 0, // Will be updated after items are added
            'status' => $this->faker->randomElement(['pending', 'processing', 'completed', 'cancelled']),
            'delivery_status' => $this->faker->randomElement(['pending', 'shipped', 'delivered']),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function ($order) {
            $itemsCount = $this->faker->numberBetween(1, 5);

            \App\Models\OrderItem::factory()
                ->count($itemsCount)
                ->create(['order_id' => $order->id]);

            // Update total_amount after creating order items
            $order->update([
                'total_amount' => $order->items->sum('total_price'),
            ]);
        });
    }

    public function pending()
    {
        return $this->state([
            'status' => 'pending',
            'delivery_status' => 'pending',
        ]);
    }

    public function completed()
    {
        return $this->state([
            'status' => 'completed',
            'delivery_status' => 'delivered',
        ]);
    }
}
