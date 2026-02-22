<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE inputs MODIFY COLUMN type ENUM(
            'text', 'textarea', 'select', 'radio', 'checkbox', 'date', 'time',
            'number', 'email', 'phone', 'url', 'file', 'image', 'video', 'audio',
            'link', 'repeatable'
        ) NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE inputs MODIFY COLUMN type ENUM(
            'text', 'textarea', 'select', 'radio', 'checkbox', 'date', 'time',
            'number', 'email', 'phone', 'url', 'file', 'image', 'video', 'audio',
            'link'
        ) NULL");
    }
};
