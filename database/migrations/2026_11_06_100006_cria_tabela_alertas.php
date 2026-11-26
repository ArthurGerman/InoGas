<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
 * Uma linha por ocorrência de alerta. dispositivo_id e local_id aceitam vazio
 * porque o sensor atual ainda não diz de qual dispositivo veio a leitura.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alertas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dispositivo_id')->nullable()->constrained('dispositivos')->nullOnDelete();
            $table->foreignId('local_id')->nullable()->constrained('locais')->nullOnDelete();
            $table->string('nivel', 10); // atencao ou risco
            $table->integer('pico_bruto');
            $table->decimal('pico_ppm', 8, 2)->nullable();
            $table->timestamp('iniciado_em')->nullable();
            $table->timestamp('encerrado_em')->nullable(); // vazio enquanto o alerta está ativo
            $table->boolean('simulado')->default(false);
            $table->foreignId('silenciado_por')->nullable()->constrained('usuarios')->nullOnDelete();
            $table->timestamp('silenciado_em')->nullable();
            $table->timestamps();

            $table->index(['local_id', 'iniciado_em']);
            $table->index('encerrado_em');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alertas');
    }
};
