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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->text('address');
            $table->date('date_of_birth');
            $table->date('hire_date');
            $table->enum('employment_type', ['full_time', 'part_time', 'contract']);
            $table->json('working_days'); // ['monday', 'tuesday', ...]
            $table->time('start_time');
            $table->time('end_time');
            $table->decimal('salary_per_hour', 10, 2);
            $table->text('specialization')->nullable(); // Hair coloring, etc.
            $table->string('photo')->nullable();
            $table->text('emergency_contact_name');
            $table->string('emergency_contact_phone');
            $table->text('bank_account_details')->nullable();
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
