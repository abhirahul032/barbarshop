<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('team_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained()->onDelete('cascade');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone_number')->nullable();
            $table->string('additional_phone_number')->nullable();
            $table->date('birthday')->nullable();
            $table->string('country')->nullable();
            $table->string('job_title')->nullable();
            $table->boolean('visible_to_clients')->default(true);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->enum('employment_type', ['full_time', 'part_time', 'contract', 'temporary'])->nullable();
            $table->string('team_member_id')->nullable()->comment('Identifier for external systems like payroll');
            $table->text('notes')->nullable();
            $table->string('calendar_color')->default('#3B82F6');
            $table->decimal('rating', 3, 2)->nullable();
            $table->integer('review_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('team_members');
    }
};