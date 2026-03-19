<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('plans')) {
            return;
        }

        if (!Schema::hasColumn('plans', 'target_user')) {
            return;
        }

        // Convert existing target_user scalar column to JSON array column.
        DB::statement('ALTER TABLE `plans` ADD COLUMN `target_user_json` JSON NULL AFTER `posts_limit`');
        DB::statement("
            UPDATE `plans`
            SET `target_user_json` = CASE
                WHEN `target_user` IS NULL OR `target_user` = '' THEN JSON_ARRAY()
                ELSE JSON_ARRAY(`target_user`)
            END
        ");
        DB::statement('ALTER TABLE `plans` DROP COLUMN `target_user`');
        DB::statement('ALTER TABLE `plans` CHANGE `target_user_json` `target_user` JSON NOT NULL');
    }

    public function down(): void
    {
        if (!Schema::hasTable('plans') || !Schema::hasColumn('plans', 'target_user')) {
            return;
        }

        // Revert JSON array target_user to enum scalar by taking the first array item.
        DB::statement("ALTER TABLE `plans` ADD COLUMN `target_user_enum` ENUM('individual','origin') NULL AFTER `posts_limit`");
        DB::statement("
            UPDATE `plans`
            SET `target_user_enum` = CASE
                WHEN JSON_LENGTH(`target_user`) > 0 THEN JSON_UNQUOTE(JSON_EXTRACT(`target_user`, '$[0]'))
                ELSE NULL
            END
        ");
        DB::statement('ALTER TABLE `plans` DROP COLUMN `target_user`');
        DB::statement("ALTER TABLE `plans` CHANGE `target_user_enum` `target_user` ENUM('individual','origin') NULL");
    }
};

