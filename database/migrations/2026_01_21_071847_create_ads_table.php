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
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->string('title_en')->nullable();             
            $table->string('title_ar')->nullable();
            $table->text('description_en')->nullable(); 
            $table->text('description_ar')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('btn_text_en')->nullable();
            $table->string('btn_text_ar')->nullable();
            $table->string('btn_link')->nullable();
            $table->boolean('btn_is_active')->default(false);
            $table->enum('type', ['promotion','interface'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ads');
    }
};
