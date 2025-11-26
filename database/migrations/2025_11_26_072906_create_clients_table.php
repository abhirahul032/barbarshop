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
         Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained()->onDelete('cascade');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->text('notes')->nullable();
            
            // New fields from screenshots
            $table->date('birthday')->nullable();
            $table->integer('birth_year')->nullable();
            $table->string('gender')->nullable();
            $table->string('pronouns')->nullable();
            $table->string('client_source')->default('walk-in');
            $table->foreignId('referred_by_client_id')->nullable()->constrained('clients');
            $table->string('preferred_language')->default('en');
            $table->string('occupation')->nullable();
            $table->string('country')->nullable();
            $table->string('additional_email')->nullable();
            $table->string('additional_phone')->nullable();
            
            // Notification settings
            $table->boolean('email_notifications')->default(true);
            $table->boolean('text_message_notifications')->default(true);
            $table->boolean('whatsapp_notifications')->default(false);
            $table->boolean('email_marketing')->default(false);
            $table->boolean('text_message_marketing')->default(false);
            $table->boolean('whatsapp_marketing')->default(false);
            
            $table->timestamps();
        });
        
         Schema::create('client_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['home', 'work', 'other'])->default('home');
            $table->string('address_name');
            $table->string('address_line_1');
            $table->string('address_line_2')->nullable();
            $table->string('apt_suite')->nullable();
            $table->string('district')->nullable();
            $table->string('city');
            $table->string('region');
            $table->string('postcode');
            $table->string('country');
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
        });
        
         Schema::create('client_emergency_contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->string('full_name');
            $table->string('email')->nullable();
            $table->string('phone');
            $table->string('relationship');
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
