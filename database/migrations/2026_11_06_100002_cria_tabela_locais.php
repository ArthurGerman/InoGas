<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
 * Locais em árvore: residência ou prédio > andar > unidade > cômodo.
 * (No model, use: protected $table = 'locais';)
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('locais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('responsavel_id')->constrained('usuarios')->restrictOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('locais')->restrictOnDelete();
            $table->string('tipo', 20); // residencia, predio, andar, unidade ou comodo
            $table->string('nome');
            $table->json('planta_json')->nullable();
            $table->timestamps();

            $table->index(['responsavel_id', 'tipo']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('locais');
    }
};
