<?php

namespace App\Http\Controllers;

use App\Models\Local;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * Locais do responsável (residência ou prédio > andar > unidade > cômodo).
 * Cada responsável só enxerga e mexe nos próprios locais.
 */
class LocalController extends Controller
{
    private function doUsuario(Local $local): void
    {
        abort_unless($local->responsavel_id === (int) session('usuario_id'), 404);
    }

    public function criar(Request $request): JsonResponse
    {
        $dados = $request->validate([
            'nome' => 'required|string|max:255',
            'tipo' => ['required', Rule::in(array_keys(Local::TIPOS))],
            'parent_id' => 'nullable|integer',
        ]);

        $pai = null;

        if (! empty($dados['parent_id'])) {
            $pai = Local::where('responsavel_id', session('usuario_id'))->find($dados['parent_id']);

            if (! $pai) {
                return response()->json(['erro' => 'O local escolhido para ficar "dentro de" não existe.'], 422);
            }
        }

        $permitidos = Local::PAIS_PERMITIDOS[$dados['tipo']];
        $tipoDoPai = $pai ? $pai->tipo : null;

        if (! in_array($tipoDoPai, $permitidos, true)) {
            return response()->json(['erro' => $this->mensagemDeHierarquia($dados['tipo'])], 422);
        }

        $local = Local::create([
            'responsavel_id' => (int) session('usuario_id'),
            'parent_id' => $pai ? $pai->id : null,
            'tipo' => $dados['tipo'],
            'nome' => $dados['nome'],
        ]);

        return response()->json(['mensagem' => 'Local criado.', 'id' => $local->id]);
    }

    public function renomear(Request $request, Local $local): JsonResponse
    {
        $this->doUsuario($local);

        $dados = $request->validate(['nome' => 'required|string|max:255']);
        $local->update(['nome' => $dados['nome']]);

        return response()->json(['mensagem' => 'Nome salvo.']);
    }

    public function apagar(Local $local): JsonResponse
    {
        $this->doUsuario($local);

        if ($local->filhos()->exists()) {
            return response()->json(['erro' => 'Este local tem outros locais dentro dele. Apague ou mova os de dentro primeiro.'], 409);
        }

        if ($local->dispositivos()->exists()) {
            return response()->json(['erro' => 'Este local tem sensores. Mova os sensores para outro local primeiro.'], 409);
        }

        $local->delete();

        return response()->json(['mensagem' => 'Local apagado.']);
    }

    private function mensagemDeHierarquia(string $tipo): string
    {
        return match ($tipo) {
            'residencia', 'predio' => 'Residência e prédio ficam no topo, sem "dentro de".',
            'andar' => 'Um andar fica dentro de um prédio.',
            'unidade' => 'Uma unidade fica dentro de um prédio ou de um andar.',
            'comodo' => 'Um cômodo fica dentro de uma residência ou de uma unidade.',
            default => 'Esse tipo de local não pode ficar aí.',
        };
    }
}
