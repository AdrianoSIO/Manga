<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categorie_projets', function (Blueprint $table) {
            $table->id();

            $table->foreignId('possibilite_projet_id')
                ->constrained('possibilite_projets')
                ->cascadeOnDelete();

            $table->string('nom');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categorie_projets');
    }
};