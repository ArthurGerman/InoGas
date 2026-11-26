<?php

namespace App\Http\Controllers;

use App\Models\Dispositivo;
use App\Models\Local;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

/**
 * Sensores do responsável. O sensor nunca é apagado (para não perder o histórico): só desativado.
 */
class DispositivoController extends Controller
{
    private function doUsuario(Dispositivo $dispositivo): void
    {
        $local = $dispositivo->local;

        abort_unless($local && $local->responsavel_id === (int) session('usuario_id'), 404);
    }

    private function localDoUsuario(int $localId): ?Local
    {
        return Local::where('responsavel_id', session('usuario_id'))->find($localId);
    }

    /** Depois de qualquer mudança nos sensores, o controlador da leitura precisa reaprender quem é quem. */
    private function esquecerCaches(?string $hashAntigo = null): void
    {
        Cache::forget('dispositivo_unico');

        if ($hashAntigo) {
            Cache::forget('dispositivo_token_' . $hashAntigo);
        }
    }

    /** Estado de comunicação de todos os sensores (a tela consulta isto a cada poucos segundos). */
    public function estado(): JsonResponse
    {
        $sensores = Dispositivo::whereHas('local', fn ($q) => $q->where('responsavel_id', session('usuario_id')))
            ->get()
            ->map(fn (Dispositivo $d) => [
                'id' => $d->id,
                'comunicacao' => $d->comunicacao(),
                'ultimo_envio_hm' => optional($d->ultimo_envio_em)->format('H:i:s'),
            ]);

        return response()->json($sensores->values()->all());
    }

    public function criar(Request $request): JsonResponse
    {
        $dados = $request->validate([
            'nome' => 'required|string|max:255',
            'local_id' => 'required|integer',
            'ultima_calibracao_em' => 'nullable|date|before_or_equal:today',
        ]);

        if (! $this->localDoUsuario($dados['local_id'])) {
            return response()->json(['erro' => 'Escolha um local seu para o sensor.'], 422);
        }

        $dispositivo = Dispositivo::create([
            'local_id' => $dados['local_id'],
            'nome' => $dados['nome'],
            'ultima_calibracao_em' => $dados['ultima_calibracao_em'] ?? null,
            'ativo' => true,
        ]);

        $token = $dispositivo->gerarToken();
        $this->esquecerCaches();

        return response()->json([
            'mensagem' => 'Sensor cadastrado.',
            'id' => $dispositivo->id,
            'token' => $token,
        ]);
    }

    public function atualizar(Request $request, Dispositivo $dispositivo): JsonResponse
    {
        $this->doUsuario($dispositivo);

        $dados = $request->validate([
            'nome' => 'required|string|max:255',
            'local_id' => 'required|integer',
            'ultima_calibracao_em' => 'nullable|date|before_or_equal:today',
        ]);

        if (! $this->localDoUsuario($dados['local_id'])) {
            return response()->json(['erro' => 'Escolha um local seu para o sensor.'], 422);
        }

        $dispositivo->update([
            'nome' => $dados['nome'],
            'local_id' => $dados['local_id'],
            'ultima_calibracao_em' => $dados['ultima_calibracao_em'] ?? null,
        ]);

        $this->esquecerCaches($dispositivo->token_hash);

        return response()->json(['mensagem' => 'Sensor salvo.']);
    }

    /** Gera um token novo. O antigo deixa de valer. O texto do token aparece só nesta resposta. */
    public function novoToken(Dispositivo $dispositivo): JsonResponse
    {
        $this->doUsuario($dispositivo);

        $hashAntigo = $dispositivo->token_hash;
        $token = $dispositivo->gerarToken();
        $this->esquecerCaches($hashAntigo);

        return response()->json(['mensagem' => 'Novo token gerado.', 'token' => $token]);
    }

    public function ativo(Request $request, Dispositivo $dispositivo): JsonResponse
    {
        $this->doUsuario($dispositivo);

        $dados = $request->validate(['ativo' => 'required|boolean']);
        $dispositivo->ativo = (bool) $dados['ativo'];
        $dispositivo->save();

        $this->esquecerCaches($dispositivo->token_hash);

        return response()->json(['mensagem' => $dispositivo->ativo ? 'Sensor ativado.' : 'Sensor desativado.']);
    }
}
