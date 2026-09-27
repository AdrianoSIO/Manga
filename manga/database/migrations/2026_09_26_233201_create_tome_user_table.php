<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tome_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tome_id')->constrained()->cascadeOnDelete();
            $table->enum('statut', ['possede', 'a_acheter'])->default('a_acheter');
            $table->date('date_acquisition')->nullable();
            $table->decimal('prix', 8, 2)->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'tome_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tome_user');
    }
};