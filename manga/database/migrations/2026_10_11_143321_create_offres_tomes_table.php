<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('offres_tomes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tome_recherche_id')
                ->constrained('tomes_recherches')
                ->cascadeOnDelete();

            $table->string('boutique');
            $table->decimal('prix', 8, 2)->nullable();
            $table->text('url');
            $table->boolean('disponible')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('offres_tomes');
    }
};