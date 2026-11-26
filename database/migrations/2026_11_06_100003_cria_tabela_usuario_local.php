<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/* Diz quais locais cada morador pode ver. */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuario_local', function (Blueprint $table) {
            $table->foreignId('usuario_id')->constrained('usuarios')->cascadeOnDelete();
            $table->foreignId('local_id')->constrained('locais')->cascadeOnDelete();
            $table->timestamps();

            $table->primary(['usuario_id', 'local_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuario_local');
    }
};
