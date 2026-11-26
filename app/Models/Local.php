<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Um local em árvore: residência ou prédio > andar > unidade > cômodo.
 */
class Local extends Model
{
    protected $table = 'locais';

    protected $fillable = [
        'responsavel_id',
        'parent_id',
        'tipo',
        'nome',
        'planta_json',
    ];

    protected $casts = [
        'planta_json' => 'array',
    ];

    /** Nome de cada tipo, como aparece nas telas. */
    public const TIPOS = [
        'residencia' => 'Residência',
        'predio' => 'Prédio',
        'andar' => 'Andar',
        'unidade' => 'Unidade',
        'comodo' => 'Cômodo',
    ];

    /** Dentro de qual tipo cada tipo pode ficar (null = no topo, sem local pai). */
    public const PAIS_PERMITIDOS = [
        'residencia' => [null],
        'predio' => [null],
        'andar' => ['predio'],
        'unidade' => ['predio', 'andar'],
        'comodo' => ['residencia', 'unidade'],
    ];

    public function pai(): BelongsTo
    {
        return $this->belongsTo(Local::class, 'parent_id');
    }

    public function filhos(): HasMany
    {
        return $this->hasMany(Local::class, 'parent_id');
    }

    public function dispositivos(): HasMany
    {
        return $this->hasMany(Dispositivo::class, 'local_id');
    }

    /** Os ids recebidos mais todos os locais que ficam dentro deles, em qualquer nível. */
    public static function idsComDescendentes(array $ids): array
    {
        $todos = $ids;
        $fila = $ids;

        for ($nivel = 0; $nivel < 10 && ! empty($fila); $nivel++) {
            $fila = self::whereIn('parent_id', $fila)->pluck('id')->all();
            $todos = array_merge($todos, $fila);
        }

        return array_values(array_unique($todos));
    }

    public function rotuloTipo(): string
    {
        return self::TIPOS[$this->tipo] ?? $this->tipo;
    }

    /** Caminho completo, do topo até este local. Ex.: "Prédio Sol › Andar 2 › Apto 201 › Cozinha". */
    public function caminho(): string
    {
        $nomes = [$this->nome];
        $atual = $this;

        for ($i = 0; $i < 10 && $atual->parent_id; $i++) {
            $atual = $atual->pai;
            if (! $atual) {
                break;
            }
            array_unshift($nomes, $atual->nome);
        }

        return implode(' › ', $nomes);
    }

    /** Nome do local de topo (a residência ou o prédio). */
    public function raiz(): Local
    {
        $atual = $this;

        for ($i = 0; $i < 10 && $atual->parent_id; $i++) {
            $pai = $atual->pai;
            if (! $pai) {
                break;
            }
            $atual = $pai;
        }

        return $atual;
    }
}
