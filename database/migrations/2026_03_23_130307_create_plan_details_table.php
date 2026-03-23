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
        Schema::create('plan_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_id')->constrained('plans')->onDelete('cascade');
            $table->decimal('price', 10, 2);
            $table->unsignedInteger('duration')->default(0);
            $table->unsignedInteger('free_trial_duration')->default(0);
            $table->enum('free_trial_duration_type', ['days', 'months', 'years'])->default('days');
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('cascade');
            $table->boolean('is_promoted')->default(false);
            $table->enum('promotion_type', ['gold', 'silver'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_details');
    }
};
