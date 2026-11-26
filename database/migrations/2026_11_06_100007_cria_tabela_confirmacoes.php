<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/* Quem clicou em "Estou ciente" em cada alerta. */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('confirmacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alerta_id')->constrained('alertas')->cascadeOnDelete();
            $table->foreignId('usuario_id')->constrained('usuarios')->restrictOnDelete();
            $table->timestamp('confirmado_em')->useCurrent();

            $table->unique(['alerta_id', 'usuario_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('confirmacoes');
    }
};
