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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('plan_id')->constrained('plans')->onDelete('cascade');
            $table->foreignId('plan_detail_id')->constrained('plan_details')->onDelete('cascade');
            $table->date('start_date')->default(now());
            $table->date('end_date')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->enum('status', ['active', 'expired', 'cancelled']);
            $table->unsignedInteger('available_posts_limit')->default(0);
            $table->unsignedInteger('plan_posts_limit')->default(1);
            $table->unsignedInteger('golde_posts')->default(0);
            $table->unsignedInteger('silver_posts')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
