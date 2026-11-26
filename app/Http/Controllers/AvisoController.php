<?php

namespace App\Http\Controllers;

use App\Models\ConfiguracaoAviso;
use App\Models\Local;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Ajustes de aviso por local. Só o responsável salva, e só nos locais dele.
 */
class AvisoController extends Controller
{
    public function salvar(Request $request, Local $local): JsonResponse
    {
        abort_unless($local->responsavel_id === (int) session('usuario_id'), 404);

        $dados = $request->validate([
            'voz_ativa' => 'required|boolean',
            'volume' => 'required|integer|min:0|max:100',
            'telegram_ativo' => 'required|boolean',
            'minutos_para_escalar' => 'required|integer|min:1|max:120',
        ]);

        ConfiguracaoAviso::updateOrCreate(['local_id' => $local->id], $dados);

        return response()->json(['mensagem' => 'Ajustes de aviso salvos.']);
    }
}
