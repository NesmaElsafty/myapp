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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name_en')->nullable();
            $table->string('name_ar')->nullable();
            
            $table->decimal('price', 10, 2);
            $table->unsignedInteger('duration');
            $table->enum('duration_type', ['days', 'months', 'years']);
            // Number of free trial days (e.g. 7, 14, 30)
            $table->unsignedInteger('free_trial_duration');
            $table->enum('free_trial_duration_type', ['days', 'months', 'years']);
            $table->unsignedInteger('posts_limit');
            $table->json('target_user');
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
