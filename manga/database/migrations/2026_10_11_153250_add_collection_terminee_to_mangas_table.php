<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mangas', function (Blueprint $table) {
            $table->boolean('collection_terminee')
                ->default(false)
                ->after('titre');
        });
    }

    public function down(): void
    {
        Schema::table('mangas', function (Blueprint $table) {
            $table->dropColumn('collection_terminee');
        });
    }
};