<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
 * Só ACRESCENTA colunas em "usuarios". Todas têm valor padrão ou aceitam vazio,
 * então o cadastro e o login que existem hoje continuam funcionando sem mudança.
 * As contas atuais viram "responsavel" automaticamente.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->string('papel', 20)->default('responsavel')->after('password');
            $table->foreignId('responsavel_id')->nullable()->after('papel')
                ->constrained('usuarios')->restrictOnDelete();
            $table->boolean('ativo')->default(true)->after('responsavel_id');
            $table->boolean('precisa_trocar_senha')->default(false)->after('ativo');
            $table->string('telegram_chat_id', 64)->nullable()->after('precisa_trocar_senha');
            $table->string('pin_hash')->nullable()->after('telegram_chat_id');

            $table->index('papel');
        });
    }

    public function down(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropConstrainedForeignId('responsavel_id');
            $table->dropIndex(['papel']);
            $table->dropColumn(['papel', 'ativo', 'precisa_trocar_senha', 'telegram_chat_id', 'pin_hash']);
        });
    }
};
