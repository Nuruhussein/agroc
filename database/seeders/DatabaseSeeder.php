<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        \App\Models\User::factory(10)->create();
        \App\Models\Produce::factory(15)->create();
        \App\Models\Order::factory(10)->create();
        \App\Models\PriceGuide::factory(5)->create();
        \App\Models\Message::factory(20)->create();
        \App\Models\Rating::factory(10)->create();
        \App\Models\Notification::factory(10)->create();
        $this->call([
            UserSeeder::class,
            ProduceSeeder::class,
            OrderSeeder::class,
            PriceGuideSeeder::class,
            MessageSeeder::class,
            RatingSeeder::class,
            NotificationSeeder::class,
        ]);
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
