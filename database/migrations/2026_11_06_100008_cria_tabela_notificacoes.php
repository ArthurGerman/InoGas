<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/* Cada aviso do alerta escalonado (tela, voz, telegram). */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notificacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alerta_id')->constrained('alertas')->cascadeOnDelete();
            $table->foreignId('usuario_id')->nullable()->constrained('usuarios')->nullOnDelete();
            $table->string('canal', 20); // tela, voz ou telegram
            $table->unsignedTinyInteger('etapa')->default(1);
            $table->string('status', 20)->default('pendente'); // pendente, enviada ou falhou
            $table->timestamp('enviada_em')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notificacoes');
    }
};
