<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
 * Só ACRESCENTA colunas em "leituras". "valor" e "status" NÃO mudam, e as colunas novas
 * aceitam vazio ou têm padrão, então o código que grava hoje (valor e status) segue igual.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('leituras', function (Blueprint $table) {
            $table->foreignId('dispositivo_id')->nullable()->after('status')
                ->constrained('dispositivos')->nullOnDelete();
            $table->decimal('valor_ppm', 8, 2)->nullable()->after('dispositivo_id');
            $table->boolean('simulada')->default(false)->after('valor_ppm');

            $table->index(['dispositivo_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::table('leituras', function (Blueprint $table) {
            $table->dropIndex(['dispositivo_id', 'created_at']);
            $table->dropConstrainedForeignId('dispositivo_id');
            $table->dropColumn(['valor_ppm', 'simulada']);
        });
    }
};
