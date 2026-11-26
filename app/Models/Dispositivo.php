<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

/**
 * Um sensor instalado em um local. O token (guardado só com hash) identifica o sensor quando
 * o firmware passar a enviá-lo.
 */
class Dispositivo extends Model
{
    protected $table = 'dispositivos';

    protected $fillable = [
        'local_id',
        'nome',
        'modelo',
        'ultima_calibracao_em',
        'ativo',
    ];

    protected $casts = [
        'ultimo_envio_em' => 'datetime',
        'ultima_calibracao_em' => 'date',
        'ativo' => 'boolean',
    ];

    protected $hidden = [
        'token_hash',
    ];

    public function local(): BelongsTo
    {
        return $this->belongsTo(Local::class, 'local_id');
    }

    /** Gera um token novo. Devolve o texto puro (mostrado uma única vez) e já grava o hash. */
    public function gerarToken(): string
    {
        $token = Str::random(40);
        $this->token_hash = self::hashDoToken($token);
        $this->save();

        return $token;
    }

    public static function hashDoToken(string $token): string
    {
        return hash('sha256', $token);
    }

    /** "recebendo" se o último envio foi há menos de N segundos; senão "sem". */
    public function comunicacao(): string
    {
        $limite = (int) config('inogas.sensores_comunicacao_segundos', 120);

        if (! $this->ultimo_envio_em) {
            return 'sem';
        }

        return $this->ultimo_envio_em->diffInSeconds(now(), false) <= $limite ? 'recebendo' : 'sem';
    }
}
