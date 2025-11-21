<?php
// database/migrations/2024_01_01_000002_create_pay_runs_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pay_runs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_member_id')->constrained()->onDelete('cascade');
            
            // Preferred Payment Method
            $table->enum('preferred_payment_method', ['manual', 'bank_transfer', 'cash', 'check'])->default('manual');
            
            // Calculation of Pay Runs
            $table->enum('pay_calculation', ['automatic', 'manual'])->default('automatic');
            
            // Pay Run Deductions
            $table->boolean('deduct_processing_fees')->default(false);
            $table->boolean('deduct_client_fees')->default(false);
            $table->decimal('processing_fee_percentage', 5, 2)->default(100.00);
            $table->decimal('client_fee_percentage', 5, 2)->default(100.00);
            
            // Cash Advances
            $table->boolean('record_cash_advances')->default(false);
            $table->boolean('auto_record_cash_payments')->default(false);
            
            // Pay Run Schedule
            $table->enum('pay_frequency', ['weekly', 'bi_weekly', 'monthly', 'semi_monthly'])->default('weekly');
            $table->string('pay_schedule')->nullable(); // Custom schedule details
            $table->date('next_pay_date')->nullable();
            
            // Additional Settings
            $table->boolean('include_commissions')->default(true);
            $table->boolean('include_tips')->default(true);
            $table->boolean('include_bonuses')->default(true);
            $table->boolean('auto_generate_pay_runs')->default(false);
            
            $table->timestamps();
            
            $table->unique('team_member_id');
        });

        // Pay Run History Table
        Schema::create('pay_run_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_member_id')->constrained()->onDelete('cascade');
            $table->date('pay_period_start');
            $table->date('pay_period_end');
            $table->date('pay_date');
            $table->decimal('total_earnings', 10, 2)->default(0);
            $table->decimal('base_wages', 10, 2)->default(0);
            $table->decimal('overtime_wages', 10, 2)->default(0);
            $table->decimal('commissions', 10, 2)->default(0);
            $table->decimal('tips', 10, 2)->default(0);
            $table->decimal('bonuses', 10, 2)->default(0);
            $table->decimal('deductions', 10, 2)->default(0);
            $table->decimal('processing_fees', 10, 2)->default(0);
            $table->decimal('client_fees', 10, 2)->default(0);
            $table->decimal('net_pay', 10, 2)->default(0);
            $table->enum('payment_method', ['manual', 'bank_transfer', 'cash', 'check'])->default('manual');
            $table->enum('status', ['draft', 'processed', 'paid', 'cancelled'])->default('draft');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['team_member_id', 'pay_date']);
        });

        // Pay Run Deductions Table
        Schema::create('pay_run_deductions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pay_run_history_id')->constrained()->onDelete('cascade');
            $table->string('description');
            $table->decimal('amount', 10, 2);
            $table->enum('type', ['fee', 'tax', 'advance', 'other'])->default('fee');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pay_run_deductions');
        Schema::dropIfExists('pay_run_history');
        Schema::dropIfExists('pay_runs');
    }
};