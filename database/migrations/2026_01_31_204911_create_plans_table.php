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
        if (Schema::hasTable('plans')) {
            return;
        }

        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->enum('target_user', ['individual', 'origin']);
            $table->enum('plan_type', ['one_post', 'many_posts']);
            $table->unsignedInteger('posts_limit');
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
