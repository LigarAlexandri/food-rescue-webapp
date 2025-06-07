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
        // Add the new column to the 'users' table
        Schema::table('users', function (Blueprint $table) {
            $table->string('whatsapp_number')->nullable()->after('phone_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Define how to roll back the migration
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('whatsapp_number');
        });
    }
};
