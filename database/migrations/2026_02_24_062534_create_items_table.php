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
            $table->foreignId('city_id')->constrained('cities')->onDelete('cascade');
            $table->foreignId('region_id')->constrained('regions')->onDelete('cascade');
            $table->string('district')->nullable();
            $table->string('street')->nullable();
            $table->boolean('is_active')->default(true);

            // contact information
            $table->string('contact_name')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_email')->nullable();
            $table->enum('contact_type', ['whatsapp', 'phone', 'email'])->nullable();
            $table->boolean('appear_in_item')->default(false);
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
