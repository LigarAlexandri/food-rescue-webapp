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
        Schema::create('food_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('quantity'); // e.g., "3 porsi", "5 buah"
            $table->text('pickup_location');
            $table->dateTime('pickup_start_time');
            $table->dateTime('pickup_end_time');
            $table->enum('status', ['available', 'claimed', 'completed', 'unavailable', 'expired'])->default('available');
            $table->foreignId('claimed_by_recipient_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('image_url')->nullable(); // Optional
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food_items');
    }
};

// ---