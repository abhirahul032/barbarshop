<?php
// database/migrations/2024_01_01_000000_create_wages_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('wages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_member_id')->constrained()->onDelete('cascade');
            $table->enum('compensation_type', ['hourly', 'salary'])->default('hourly');
            $table->decimal('hourly_rate', 10, 2)->default(0);
            $table->decimal('salary_amount', 10, 2)->nullable();
            $table->enum('salary_period', ['monthly', 'annually'])->nullable();
            
            // Overtime settings
            $table->boolean('overtime_enabled')->default(false);
            $table->decimal('regular_hours', 5, 2)->default(40.0);
            $table->enum('hours_type', ['per_week', 'per_month'])->default('per_week');
            $table->enum('overtime_type', ['hourly', 'fixed'])->default('hourly');
            $table->decimal('overtime_rate', 10, 2)->default(0);
            
            // Timesheet settings
            $table->enum('location_restrictions', ['workspace_default', 'enabled', 'disabled'])->default('workspace_default');
            $table->enum('timesheet_automation', ['workspace_default', 'auto_clock_in', 'disabled'])->default('workspace_default');
            $table->enum('automated_breaks', ['workspace_default', 'enabled', 'disabled'])->default('workspace_default');
            $table->enum('auto_check_out', ['workspace_default', 'enabled', 'disabled'])->default('workspace_default');
            
            $table->timestamps();
            
            $table->unique('team_member_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('wages');
    }
};