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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');

            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('price')->nullable();
            $table->string('price_after_discount')->nullable();
            $table->string('location')->nullable();
            $table->string('lat')->nullable();
            $table->string('long')->nullable();

            $table->string('available_datetime')->nullable();
            $table->enum('payment_platform', ['cash', 'installment'])->nullable();
            // make city and region nullable
            $table->foreignId('city_id')->nullable()->constrained('cities');
            $table->foreignId('region_id')->nullable()->constrained('regions');
           
            $table->string('district')->nullable();
            $table->string('street')->nullable();
            $table->boolean('is_active')->default(true);

            // contact information
            $table->string('contact_name')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_email')->nullable();
            $table->enum('contact_type', ['whatsapp', 'phone', 'email'])->nullable();
            $table->boolean('appear_in_item')->default(false);
            $table->enum('status', ['draft', 'in_progress', 'completed'])->default('draft');
            $table->foreignId('current_screen_id')->nullable()->constrained('screens')->nullOnDelete();
            $table->dateTime('completed_at')->nullable();

            $table->boolean('need_licence')->default(false);
            $table->boolean('has_licence')->default(false);
            
            $table->string('licence_number')->nullable();
            $table->string('licence_type')->nullable();
            

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
