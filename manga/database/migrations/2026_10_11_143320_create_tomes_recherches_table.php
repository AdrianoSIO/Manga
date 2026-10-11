<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tomes_recherches', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('manga_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->unsignedInteger('numero');

            $table->timestamps();

            $table->unique(
                ['user_id', 'manga_id', 'numero'],
                'tome_recherche_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tomes_recherches');
    }
};