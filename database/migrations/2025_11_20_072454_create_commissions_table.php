<?php
// database/migrations/2024_01_01_000001_create_commissions_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_member_id')->constrained()->onDelete('cascade');
            
            // Services Commission
            $table->boolean('services_commission_enabled')->default(true);
            $table->enum('services_commission_type', ['fixed_rate', 'percentage'])->default('fixed_rate');
            $table->decimal('services_default_rate', 10, 2)->default(0);
            $table->enum('services_calculation_type', ['default', 'custom'])->default('default');
            
            // Products Commission
            $table->boolean('products_commission_enabled')->default(false);
            $table->enum('products_commission_type', ['fixed_rate', 'percentage'])->default('fixed_rate');
            $table->decimal('products_default_rate', 10, 2)->default(0);
            $table->enum('products_calculation_type', ['default', 'custom'])->default('default');
            
            // Memberships Commission
            $table->boolean('memberships_commission_enabled')->default(false);
            $table->enum('memberships_commission_type', ['fixed_rate', 'percentage'])->default('fixed_rate');
            $table->decimal('memberships_default_rate', 10, 2)->default(0);
            $table->enum('memberships_calculation_type', ['default', 'custom'])->default('default');
            $table->boolean('memberships_deduct_discounts')->default(false);
            $table->boolean('memberships_deduct_taxes')->default(false);
            
            // Gift Cards Commission
            $table->boolean('gift_cards_commission_enabled')->default(false);
            $table->enum('gift_cards_commission_type', ['fixed_rate', 'percentage'])->default('fixed_rate');
            $table->decimal('gift_cards_default_rate', 10, 2)->default(0);
            $table->enum('gift_cards_calculation_type', ['default', 'custom'])->default('default');
            
            // Cancellation Commission
            $table->boolean('cancellation_commission_enabled')->default(false);
            $table->boolean('late_cancellation_fee')->default(false);
            $table->boolean('no_show_fee')->default(false);
            
            $table->timestamps();
            
            $table->unique('team_member_id');
        });

        // Commission overrides for specific services/products
        Schema::create('commission_overrides', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commission_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['service', 'product', 'membership', 'gift_card']);
            $table->foreignId('item_id'); // ID of service/product/membership/gift card
            $table->enum('commission_type', ['fixed_rate', 'percentage']);
            $table->decimal('rate', 10, 2);
            $table->timestamps();
            
            $table->unique(['commission_id', 'type', 'item_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('commission_overrides');
        Schema::dropIfExists('commissions');
    }
};