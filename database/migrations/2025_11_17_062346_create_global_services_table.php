<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('global_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_type_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('type', ['fixed', 'hourly'])->default('fixed');
            $table->decimal('price', 10, 2)->default(0);
            $table->decimal('hourly_price', 10, 2)->default(0);
            $table->integer('duration_minutes')->default(60);
            $table->string('category');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index('business_type_id');
            $table->index('category');
            $table->index('is_active');
        });
    }

    public function down()
    {
        Schema::dropIfExists('global_services');
    }
};