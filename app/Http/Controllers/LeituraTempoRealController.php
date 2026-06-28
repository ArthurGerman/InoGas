<?php

namespace App\Http\Controllers;

use App\Models\Leitura;
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

        $hora = now()->format('H:i:s');

        Cache::put('leitura_atual', [
            'valor' => $dados['valor'],
            'status' => $dados['status'],
            'hora' => $hora
        ]);

        $alerta = Cache::get('alerta_ativo', [
            'ativo' => false,
            'valor_maximo' => 0,
            'status_maximo' => $dados['status'],
            'hora_maximo' => $hora
        ]);

        if ($dados['valor'] > 200) {
            if (! $alerta['ativo']) {
                $alerta = [
                    'ativo' => true,
                    'valor_maximo' => $dados['valor'],
                    'status_maximo' => $dados['status'],
                    'hora_maximo' => $hora
                ];
            } elseif ($dados['valor'] > $alerta['valor_maximo']) {
                $alerta['valor_maximo'] = $dados['valor'];
                $alerta['status_maximo'] = $dados['status'];
                $alerta['hora_maximo'] = $hora;
            }

            Cache::put('alerta_ativo', $alerta);
        } else {
            if ($alerta['ativo']) {
                Leitura::create([
                    'valor' => $alerta['valor_maximo'],
                    'status' => $alerta['status_maximo'],
                ]);

                Cache::forget('alerta_ativo');
            }
        }

        return response()->json(['mensagem' => 'Leitura atualizada']);
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
