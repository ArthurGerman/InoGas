<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class LeituraTempoRealController extends Controller
{
    /**
     * Recebe a leitura do Node.js
     */
    public function atualizar(Request $request)
    {
        $dados = $request->validate([
            'valor' => 'required|numeric',
            'status' => 'required|string|max:100'
        ]);

        Cache::put(
            'leitura_atual',
            [
                'valor' => $dados['valor'],
                'status' => $dados['status'],
                'hora' => now()->format('H:i:s')
            ]
        );

        return response()->json([
            'mensagem' => 'Leitura atualizada'
        ]);
    }

    /**
     * Retorna a última leitura recebida
     */
    public function mostrar()
    {
        return response()->json(
            Cache::get('leitura_atual', [
                'valor' => 0,
                'status' => 'Sem dados',
                'hora' => '--:--:--'
            ])
        );
    }
}
