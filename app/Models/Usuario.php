<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Usuario extends Model
{
    protected $fillable = [
        'name',
        'email',
        'password'
    ];

    protected $hidden = [
        'password',
        'pin_hash'
    ];

    protected $casts = [
        'ativo' => 'boolean',
        'precisa_trocar_senha' => 'boolean',
    ];

    /** Moradores criados por este responsável. */
    public function moradores(): HasMany
    {
        return $this->hasMany(Usuario::class, 'responsavel_id');
    }

    /** Locais que este morador pode ver (os de dentro deles também contam). */
    public function locais(): BelongsToMany
    {
        return $this->belongsToMany(Local::class, 'usuario_local', 'usuario_id', 'local_id')->withTimestamps();
    }

    public function ehMorador(): bool
    {
        return $this->papel === 'morador';
    }

    /**
     * Ids de todos os locais que esta pessoa pode ver.
     * Responsável: todos os locais dele. Morador: os locais liberados e tudo que há dentro deles.
     */
    public function locaisVisiveisIds(): array
    {
        if (! $this->ehMorador()) {
            return Local::where('responsavel_id', $this->id)->pluck('id')->all();
        }

        return Local::idsComDescendentes($this->locais()->pluck('locais.id')->all());
    }
}
