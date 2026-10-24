<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('possibilite_projets', function (Blueprint $table) {
            $table->id();

            $table->foreignId('projet_id')
                ->constrained('projets')
                ->cascadeOnDelete();

            $table->string('nom');

            $table->text('description')
                ->nullable();

            $table->string('statut')
                ->default('a_etudier');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('possibilite_projets');
    }
};