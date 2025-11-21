<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('scheduled_shifts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_member_id')->constrained()->onDelete('cascade');
            $table->date('shift_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->enum('shift_type', ['regular', 'overtime', 'holiday'])->default('regular');
            $table->text('notes')->nullable();
            $table->boolean('is_repeating')->default(false);
            $table->enum('repeat_frequency', ['weekly', 'bi_weekly', 'monthly'])->nullable();
            $table->date('repeat_until')->nullable();
            $table->timestamps();
            
            $table->index(['team_member_id', 'shift_date']);
            $table->index('shift_date');
        });
    }

    public function down()
    {
        Schema::dropIfExists('scheduled_shifts');
    }
};