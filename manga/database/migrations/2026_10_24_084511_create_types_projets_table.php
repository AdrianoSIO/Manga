<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('types_projets', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('nom');

            $table->timestamps();

            $table->unique([
                'user_id',
                'nom',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('types_projets');
    }
};