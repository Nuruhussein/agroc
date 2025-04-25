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
        Schema::create('produce', function (Blueprint $table) {
            $table->id();
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->string('name');
        $table->foreignId('category_id')->default(1)->constrained()->onDelete('cascade');
        $table->string('location')->nullable();
        $table->string('farm_name')->nullable();
        $table->text('description')->nullable();
        $table->decimal('price', 8, 2);
        $table->decimal('original_price', 8, 2)->nullable();
        $table->unsignedTinyInteger('discount')->nullable();
        $table->boolean('organic')->default(false);
        $table->integer('quantity');
        $table->string('image_path')->nullable();
        $table->timestamps();
        });
       
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produces');
    }
};
