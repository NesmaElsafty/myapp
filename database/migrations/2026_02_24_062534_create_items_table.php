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
            $table->string('discount_percentage')->nullable();
            $table->string('price_after_discount')->nullable();
            $table->string('location')->nullable();
            $table->string('lat')->nullable();
            $table->string('long')->nullable();

            $table->string('available_datetime')->nullable();
            $table->enum('payment_platform', ['cash', 'installment'])->nullable();
            // make city and region nullable
            $table->foreignId('city_id')->nullable()->constrained('cities');
            $table->foreignId('region_id')->nullable()->constrained('regions');

            $table->json('payment_options')->nullable();
           
            $table->string('district')->nullable();
            $table->string('street')->nullable();
            $table->boolean('is_active')->default(true);

            // contact information
            $table->string('contact_name')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_email')->nullable();
            $table->json('contact_type')->nullable();
            $table->boolean('is_appeared_in_item')->default(false);
            $table->enum('status', ['draft' ,'pending_approval', 'approved', 'rejected', 'in_progress', 'soldout', 'expired'])->default('pending_approval');
            $table->dateTime('published_at')->nullable();

            $table->boolean('need_licence')->default(false);
            
            $table->string('val_licence_number')->nullable();
            $table->string('tourism_licence_number')->nullable();

            $table->json('visit_datetimes')->nullable();

            $table->boolean('is_promoted')->default(false);
            $table->dateTime('promoted_until')->nullable();
            $table->enum('promotion_type', ['golden', 'silver'])->nullable();

            
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
