<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * Apaga as amostras de leitura (uma por minuto) mais antigas que o tempo de guarda.
 * NÃO apaga:
 *  - os alertas (tabela "alertas");
 *  - leituras acima do limite de atenção (inclui os "picos" antigos, de antes das amostras).
 */
class LimparAmostras extends Command
{
    protected $signature = 'inogas:limpar-amostras {--dias= : Dias de guarda (padrão: o valor de config/inogas.php)}';

    protected $description = 'Apaga amostras de leitura antigas (os alertas ficam para sempre)';

    public function handle(): int
    {
        $dias = (int) ($this->option('dias') ?: config('inogas.amostras.guardar_dias', 30));

        if ($dias < 1) {
            $this->error('Informe pelo menos 1 dia.');

            return self::FAILURE;
        }

        $limite = now()->subDays($dias);
        $teto = (int) config('inogas.limites.atencao', 200);
        $apagadas = 0;

        do {
            $lote = DB::table('leituras')
                ->where('created_at', '<', $limite)
                ->where('valor', '<=', $teto)
                ->limit(5000)
                ->delete();

            $apagadas += $lote;
        } while ($lote > 0);

        $this->info("Amostras apagadas: {$apagadas} (mais antigas que {$dias} dias e até o limite de atenção).");

        return self::SUCCESS;
    }
}
