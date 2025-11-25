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
        Schema::create('product_brands', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('store_id')->index();
            $table->string('name');
            $table->timestamps();
        });
        
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('store_id')->index();
            $table->string('name');
            $table->timestamps();
        });
        
         Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('store_id')->index();
            $table->unsignedBigInteger('supplier_id')->nullable()->index();
            $table->unsignedBigInteger('brand_id')->nullable()->index();
            $table->unsignedBigInteger('category_id')->nullable()->index();

            $table->string('name');
            $table->string('barcode')->nullable();
            $table->string('sku')->nullable()->unique();
            $table->string('measure_unit')->nullable(); // e.g., ml, kg
            $table->decimal('measure_amount', 12, 3)->nullable();

            $table->string('short_description', 255)->nullable();
            $table->text('description')->nullable();

            // Pricing
            $table->decimal('supply_price', 12, 2)->default(0.00);
            $table->decimal('retail_price', 12, 2)->default(0.00);
            $table->decimal('markup_percent', 5, 2)->default(0.00);
            $table->unsignedBigInteger('tax_rate_id')->nullable();

            // Commission
            $table->boolean('team_commission_enabled')->default(false);
            $table->enum('team_commission_type', ['fixed','percentage'])->default('fixed');
            $table->decimal('team_commission_value', 10, 2)->default(0.00);

            // Inventory
            $table->boolean('track_stock')->default(false);
            $table->integer('stock_quantity')->default(0);
            $table->integer('low_stock_level')->nullable();
            $table->integer('reorder_quantity')->nullable();
            $table->boolean('low_stock_notifications')->default(false);

            $table->boolean('is_active')->default(true);

            $table->timestamps();

            // indexes
            $table->index(['store_id','category_id']);
        });
        
        
         Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->index();
            $table->string('path');
            $table->integer('position')->default(0);
            $table->timestamps();

            // Foreign key optional.
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_brands');
        Schema::dropIfExists('product_categories');
        Schema::dropIfExists('products');
        Schema::dropIfExists('product_images');
    }
};
