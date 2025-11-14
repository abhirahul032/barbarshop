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
        Schema::table('stores', function (Blueprint $table) {
            // Add billing period, start date, end date
            $table->enum('billing_period', ['monthly', 'yearly'])->default('monthly');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            
            // Create pivot table for store_business_type relationship
        });
        
        // Create pivot table for store_business_type many-to-many relationship
        Schema::create('business_type_store', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained()->onDelete('cascade');
            $table->foreignId('business_type_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
