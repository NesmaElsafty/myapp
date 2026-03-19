<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            // Add new columns introduced after initial migration was already run.
            if (!Schema::hasColumn('plans', 'duration')) {
                $table->string('duration')->nullable()->after('price');
            }

            if (!Schema::hasColumn('plans', 'duration_type')) {
                $table->enum('duration_type', ['days', 'months', 'years'])->nullable()->after('duration');
            }

            if (!Schema::hasColumn('plans', 'free_trial_duration')) {
                $table->unsignedInteger('free_trial_duration')->nullable()->after('duration_type');
            }

            if (!Schema::hasColumn('plans', 'free_trial_duration_type')) {
                $table->enum('free_trial_duration_type', ['days', 'months', 'years'])->nullable()->after('free_trial_duration');
            }

            // NOTE: We intentionally do not force changing existing column types here
            // (e.g. posts_limit/free_duration) to avoid requiring doctrine/dbal.
        });
    }

    public function down(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            if (Schema::hasColumn('plans', 'free_trial_duration_type')) {
                $table->dropColumn('free_trial_duration_type');
            }
            if (Schema::hasColumn('plans', 'free_trial_duration')) {
                $table->dropColumn('free_trial_duration');
            }
            if (Schema::hasColumn('plans', 'duration_type')) {
                $table->dropColumn('duration_type');
            }
            if (Schema::hasColumn('plans', 'duration')) {
                $table->dropColumn('duration');
            }
        });
    }
};

