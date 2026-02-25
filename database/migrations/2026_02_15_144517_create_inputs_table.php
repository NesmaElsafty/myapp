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
        Schema::create('inputs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('screen_id')->constrained('screens')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('title_en')->nullable();
            $table->string('title_ar')->nullable();
            $table->string('placeholder_en')->nullable();
            $table->string('placeholder_ar')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->enum('type', ['text', 'textarea', 'select', 'radio', 'checkbox', 'date', 'time', 'number', 'email', 'phone', 'url', 'file', 'image', 'video', 'audio', 'link'])->nullable();
            // options: one value per option (same for en/ar). select/radio: { choices: [{ value, label_en, label_ar }] }; checkbox: { label_en, label_ar }
            $table->json('options')->nullable();
            $table->boolean('is_required')->default(false);
            $table->json('validation_rules')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inputs');
    }
};
