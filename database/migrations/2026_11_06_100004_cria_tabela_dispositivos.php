<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dispositivos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('local_id')->constrained('locais')->restrictOnDelete();
            $table->string('nome');
            $table->string('modelo')->default('MQ-2 + ESP32');
            $table->string('token_hash')->nullable()->unique(); // senha do sensor (guardada com hash)
            $table->timestamp('ultimo_envio_em')->nullable();
            $table->timestamp('ultima_calibracao_em')->nullable();
            $table->unsignedInteger('limite_atencao')->default(200);
            $table->unsignedInteger('limite_risco')->default(500);
            $table->string('unidade', 10)->default('bruto'); // bruto ou ppm
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dispositivos');
    }
};
