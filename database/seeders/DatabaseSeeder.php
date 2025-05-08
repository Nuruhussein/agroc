<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Produce;
use App\Models\Order;
use App\Models\PriceGuide;
use App\Models\Message;
use App\Models\Rating;
use App\Models\Notification;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create users
        User::factory(10)->create();

        // Create produce
        Produce::factory(15)->create();

        // Create orders (automatically seeds order items via factory)
        Order::factory(10)->create();

        // Create additional entities
        PriceGuide::factory(5)->create();
        Message::factory(20)->create();
        Rating::factory(10)->create();
        Notification::factory(10)->create();

        // Optional: Call additional seeders if they contain custom seeding logic
        $this->call([
            UserSeeder::class,
            ProduceSeeder::class,
            OrderSeeder::class, // Currently empty — can be removed if unused
            PriceGuideSeeder::class,
            MessageSeeder::class,
            RatingSeeder::class,
            NotificationSeeder::class,
        ]);

        // Create a known test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
