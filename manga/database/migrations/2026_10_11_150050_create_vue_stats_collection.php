<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            CREATE VIEW vue_stats_collection AS
            SELECT
                user_id,
                COUNT(DISTINCT manga_id) AS total_licences,
                COUNT(*) AS total_exemplaires
            FROM tomes
            GROUP BY user_id
        ");
    }

    public function down(): void
    {
        DB::statement("
            DROP VIEW IF EXISTS vue_stats_collection
        ");
    }
};