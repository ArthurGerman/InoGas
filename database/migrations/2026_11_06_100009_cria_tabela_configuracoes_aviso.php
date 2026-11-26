<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/* Ajustes de aviso de cada local (uma linha por local). */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('configuracoes_aviso', function (Blueprint $table) {
            $table->id();
            $table->foreignId('local_id')->unique()->constrained('locais')->cascadeOnDelete();
            $table->boolean('voz_ativa')->default(true);
            $table->unsignedTinyInteger('volume')->default(60);
            $table->boolean('telegram_ativo')->default(false);
            $table->unsignedSmallInteger('minutos_para_escalar')->default(5);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('configuracoes_aviso');
    }
};
