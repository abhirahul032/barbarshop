<?php
// database/migrations/2025_11_24_000000_create_memberships_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('memberships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('color')->default('#3B82F6');
            $table->enum('session_type', ['limited', 'unlimited'])->default('limited');
            $table->integer('session_count')->nullable();
            $table->enum('validity_period', ['days', 'weeks', 'months', 'years']);
            $table->integer('validity_duration');
            $table->decimal('price', 10, 2);
            $table->foreignId('tax_rate_id')->nullable()->constrained()->onDelete('set null');
            $table->boolean('online_sales_enabled')->default(false);
            $table->boolean('online_redemption_enabled')->default(false);
            $table->text('terms_conditions')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('membership_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('membership_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('tax_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->decimal('rate', 5, 2);
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });

        Schema::create('clients', function (Blueprint $table) {
            $table->id();

            // Foreign key to stores table
            $table->unsignedBigInteger('store_id');
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');

            // Client fields
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();
        });
        
        Schema::create('client_memberships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->foreignId('membership_id')->constrained()->onDelete('cascade');
            $table->integer('sessions_used')->default(0);
            $table->integer('sessions_remaining');
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['active', 'expired', 'cancelled'])->default('active');
            $table->timestamps();
        });

        Schema::create('membership_redemptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_membership_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->foreignId('appointment_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamp('redeemed_at');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('membership_redemptions');
        Schema::dropIfExists('client_memberships');
        Schema::dropIfExists('tax_rates');
        Schema::dropIfExists('membership_services');
        Schema::dropIfExists('memberships');
        Schema::dropIfExists('clients');
    }
};