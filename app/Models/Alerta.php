<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Uma ocorrência de alerta (do momento em que a leitura passa do limite até voltar ao normal).
 */
class Alerta extends Model
{
    protected $table = 'alertas';

    protected $fillable = [
        'dispositivo_id',
        'local_id',
        'nivel',
        'pico_bruto',
        'pico_ppm',
        'iniciado_em',
        'encerrado_em',
        'simulado',
    ];

    protected $casts = [
        'iniciado_em' => 'datetime',
        'encerrado_em' => 'datetime',
        'silenciado_em' => 'datetime',
        'simulado' => 'boolean',
    ];

    public function confirmacoes(): HasMany
    {
        return $this->hasMany(Confirmacao::class, 'alerta_id');
    }

    public function local(): BelongsTo
    {
        return $this->belongsTo(Local::class, 'local_id');
    }

    public function dispositivo(): BelongsTo
    {
        return $this->belongsTo(Dispositivo::class, 'dispositivo_id');
    }

    public function silenciadoPor(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'silenciado_por');
    }

    /**
     * Alertas que a pessoa logada pode ver.
     * Morador: só os dos locais liberados para ele.
     * Responsável: os dos locais dele e também os alertas ainda sem local (de antes do cadastro).
     */
    public function scopeVisiveis($consulta)
    {
        $usuario = Usuario::find((int) session('usuario_id'));

        if (! $usuario) {
            return $consulta->whereRaw('1 = 0');
        }

        $ids = $usuario->locaisVisiveisIds();

        if ($usuario->ehMorador()) {
            return $consulta->whereIn('local_id', $ids);
        }

        return $consulta->where(fn ($q) => $q->whereIn('local_id', $ids)->orWhereNull('local_id'));
    }

    public function visivelPara(Usuario $usuario): bool
    {
        if ($this->local_id === null) {
            return ! $usuario->ehMorador();
        }

        return in_array((int) $this->local_id, $usuario->locaisVisiveisIds(), true);
    }

    /** Duração em texto curto (ex.: "2 min 10 s"), ou um traço quando não dá para calcular. */
    public function duracaoTexto(): string
    {
        if (! $this->iniciado_em || ! $this->encerrado_em) {
            return '—';
        }

        $segundos = max(0, $this->encerrado_em->getTimestamp() - $this->iniciado_em->getTimestamp());

        if ($segundos < 60) {
            return $segundos . ' s';
        }

        if ($segundos < 3600) {
            return intdiv($segundos, 60) . ' min ' . ($segundos % 60) . ' s';
        }

        return intdiv($segundos, 3600) . ' h ' . intdiv($segundos % 3600, 60) . ' min';
    }
}
