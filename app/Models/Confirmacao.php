<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Quem clicou em "Estou ciente" em cada alerta (uma vez por pessoa).
 */
class Confirmacao extends Model
{
    protected $table = 'confirmacoes';

    public $timestamps = false;

    protected $fillable = [
        'alerta_id',
        'usuario_id',
        'confirmado_em',
    ];

    protected $casts = [
        'confirmado_em' => 'datetime',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}
