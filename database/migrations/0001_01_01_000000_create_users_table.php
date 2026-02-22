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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('f_name')->nullable();
            $table->string('l_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('location')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('is_active')->default(true);
            $table->enum('type', ['user', 'admin','individual', 'agent','origin'])->nullable();
            $table->foreignId('origin_id')->nullable()->constrained('users');
            
            // for agents & individuals & origins
            $table->json('specialty_areas')->nullable()->default('[]');
            $table->string('major')->nullable();
            $table->longText('summary')->nullable();

            // bank data
            $table->string('bank_name')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('bank_account_iban')->nullable();
            $table->string('bank_account_address')->nullable();

            // language
            $table->enum('language', ['ar', 'en'])->default('ar');
           

            // $table->foreignId('role_id')->nullable()->constrained('roles');
            $table->string('national_id')->nullable();
            $table->string('commercial_number')->nullable();       
            $table->softDeletes();

            $table->rememberToken();
            $table->timestamps();

            // Composite unique indexes: email and phone must be unique per user type
            $table->unique(['email', 'type']);
            $table->unique(['phone', 'type']);
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
