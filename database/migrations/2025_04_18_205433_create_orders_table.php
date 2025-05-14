<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       // Create orders table
Schema::create('orders', function (Blueprint $table) {
    $table->id();
    $table->foreignId('buyer_id')->constrained('users')->onDelete('cascade');
    $table->string('order_number')->unique();
    $table->decimal('total_amount', 10, 2);
    $table->enum('status', ['pending', 'processing', 'completed', 'cancelled'])->default('pending');


    $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
    $table->text('shipping_address')->nullable();
    $table->text('billing_address')->nullable();
    $table->timestamps();
});

// Create order_items table
Schema::create('order_items', function (Blueprint $table) {
    $table->id();
    $table->foreignId('order_id')->constrained()->onDelete('cascade');
    $table->foreignId('produce_id')->constrained('produce')->onDelete('cascade');
    $table->integer('quantity');
    $table->decimal('unit_price', 10, 2);
    $table->decimal('total_price', 10, 2);
    $table->enum('delivery_status', ['pending', 'shipped', 'delivered'])->default('pending');

    $table->timestamps();
});
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
