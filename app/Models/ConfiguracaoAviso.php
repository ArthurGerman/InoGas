<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Ajustes de aviso de um local (uma linha por local).
 * Voz: já funciona no Painel. Telegram e minutos para escalar: por enquanto só ficam salvos.
 */
class ConfiguracaoAviso extends Model
{
    protected $table = 'configuracoes_aviso';

    protected $fillable = [
        'local_id',
        'voz_ativa',
        'volume',
        'telegram_ativo',
        'minutos_para_escalar',
    ];

    protected $casts = [
        'voz_ativa' => 'boolean',
        'telegram_ativo' => 'boolean',
        'volume' => 'integer',
        'minutos_para_escalar' => 'integer',
    ];

    /** Valores usados enquanto o local não tem ajustes salvos. */
    public const PADRAO = [
        'voz_ativa' => true,
        'volume' => 60,
        'telegram_ativo' => false,
        'minutos_para_escalar' => 5,
    ];

    public function local(): BelongsTo
    {
        return $this->belongsTo(Local::class, 'local_id');
    }

    /** Ajustes do local, ou o padrão se ainda não houver. */
    public static function do(?int $localId): array
    {
        if (! $localId) {
            return self::PADRAO;
        }

        $linha = self::where('local_id', $localId)->first();

        return $linha
            ? $linha->only(['voz_ativa', 'volume', 'telegram_ativo', 'minutos_para_escalar'])
            : self::PADRAO;
    }
}
