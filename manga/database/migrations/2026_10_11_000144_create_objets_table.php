<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('objets', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('nom');

            $table->string('categorie')->nullable();

            $table->decimal('prix', 10, 2)->nullable();

            $table->decimal('prix_cible', 10, 2)->nullable();

            $table->text('url')->nullable();

            $table->enum('importance', [
                'SSS',
                'SS',
                'S',
                'A',
                'B',
                'C',
                'D',
            ])->default('C');

            $table->boolean('disponible')->default(true);

            $table->boolean('achete')->default(false);

            $table->text('description')->nullable();

            $table->date('date_ajout');

            $table->date('date_achat')->nullable();

            $table->timestamps();

            $table->index('importance');
            $table->index('disponible');
            $table->index('achete');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('objets');
    }
};