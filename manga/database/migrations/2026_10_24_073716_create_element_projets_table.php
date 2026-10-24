<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('element_projets', function (Blueprint $table) {
            $table->id();

            $table->foreignId('categorie_projet_id')
                ->constrained('categorie_projets')
                ->cascadeOnDelete();

            $table->string('nom');

            $table->text('description')
                ->nullable();

            $table->decimal('prix', 10, 2);

            $table->unsignedInteger('quantite')
                ->default(1);

            $table->text('url')
                ->nullable();

            $table->boolean('selectionne')
                ->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('element_projets');
    }
};