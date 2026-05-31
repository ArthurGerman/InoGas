<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gas extends Model
{
    use HasFactory;

    protected $fillable = ['gas_nome', 'gas_niv_tox'];

    public function leituras()
    {
        return $this->hasMany(Leitura::class);
    }
}
