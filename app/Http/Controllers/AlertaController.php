<?php

namespace App\Http\Controllers;

use App\Models\Alerta;
use App\Models\Confirmacao;
use App\Models\Usuario;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

/**
 * Alerta ativo, "Estou ciente", silenciar com PIN e modo de teste.
 */
class AlertaController extends Controller
{
    private function ehResponsavel(): bool
    {
        return session('usuario_papel', 'responsavel') === 'responsavel';
    }

    /**
     * Estado de um alerta para a tela.
     * Os nomes de quem confirmou só vão para o responsável. O morador recebe só a quantidade.
     */
    private function estado(Alerta $alerta, int $usuarioId): array
    {
        $confirmacoes = $alerta->confirmacoes()->with('usuario:id,name')->orderBy('confirmado_em')->get();
        $minha = $confirmacoes->firstWhere('usuario_id', $usuarioId);
        $responsavel = $this->ehResponsavel();

        return [
            'id' => $alerta->id,
            'nivel' => $alerta->nivel,
            'pico' => $alerta->pico_bruto,
            'iniciado_hm' => optional($alerta->iniciado_em)->format('H:i') ?? optional($alerta->created_at)->format('H:i'),
            'silenciado_por' => $alerta->silenciado_em ? optional($alerta->silenciadoPor)->name : null,
            'silenciado_hm' => optional($alerta->silenciado_em)->format('H:i'),
            'confirmacoes_total' => $confirmacoes->count(),
            'minha_confirmacao_hm' => $minha ? optional($minha->confirmado_em)->format('H:i') : null,
            'confirmacoes' => $responsavel
                ? $confirmacoes->map(fn ($c) => [
                    'nome' => optional($c->usuario)->name ?? 'Conta removida',
                    'hora' => optional($c->confirmado_em)->format('H:i'),
                ])->values()->all()
                : null,
            'sou_responsavel' => $responsavel,
        ];
    }

    /** Alerta que está acontecendo agora (se houver). A tela consulta isto a cada poucos segundos. */
    public function ativo(): JsonResponse
    {
        $cache = Cache::get('alerta_ativo');

        if (! is_array($cache) || empty($cache['ativo']) || empty($cache['alerta_id'])) {
            return response()->json(['ativo' => false]);
        }

        $alerta = Alerta::find($cache['alerta_id']);

        if (! $alerta || $alerta->encerrado_em) {
            return response()->json(['ativo' => false]);
        }

        $usuario = Usuario::find((int) session('usuario_id'));

        if (! $usuario || ! $alerta->visivelPara($usuario)) {
            return response()->json(['ativo' => false]);
        }

        return response()->json(['ativo' => true] + $this->estado($alerta, $usuario->id));
    }

    /** Cada pessoa só mexe em alertas que consegue ver. */
    private function exigirVisivel(Alerta $alerta): Usuario
    {
        $usuario = Usuario::find((int) session('usuario_id'));

        abort_unless($usuario && $alerta->visivelPara($usuario), 404);

        return $usuario;
    }

    public function ciente(Request $request, Alerta $alerta): JsonResponse
    {
        $this->exigirVisivel($alerta);

        if ($alerta->encerrado_em) {
            return response()->json(['erro' => 'Este alerta já terminou.'], 409);
        }

        $usuarioId = (int) session('usuario_id');

        Confirmacao::firstOrCreate(
            ['alerta_id' => $alerta->id, 'usuario_id' => $usuarioId],
            ['confirmado_em' => now()]
        );

        return response()->json(['ativo' => true] + $this->estado($alerta, $usuarioId));
    }

    /**
     * Silencia o alerta NO SISTEMA (registra quem e quando). Não desliga o apito do sensor:
     * o buzzer é controlado pelo firmware do ESP32.
     */
    public function silenciar(Request $request, Alerta $alerta): JsonResponse
    {
        $request->validate(['pin' => ['required', 'regex:/^\d{4,8}$/']], [
            'pin.regex' => 'O PIN deve ter de 4 a 8 números.',
        ]);

        $usuario = $this->exigirVisivel($alerta);

        if (empty($usuario->pin_hash)) {
            return response()->json(['erro' => 'Defina seu PIN em Configurações antes de silenciar o alarme.'], 422);
        }

        if (! Hash::check($request->input('pin'), $usuario->pin_hash)) {
            return response()->json(['erro' => 'PIN incorreto.'], 422);
        }

        if ($alerta->encerrado_em) {
            return response()->json(['erro' => 'Este alerta já terminou.'], 409);
        }

        if (! $alerta->silenciado_em) {
            $alerta->silenciado_por = $usuario->id;
            $alerta->silenciado_em = now();
            $alerta->save();
        }

        return response()->json(['ativo' => true] + $this->estado($alerta, $usuario->id));
    }

    /**
     * Modo de teste: grava um alerta SIMULADO, já encerrado, marcado como teste.
     * Não vira alerta ativo no Painel e não dispara nenhum aviso.
     */
    public function teste(Request $request): JsonResponse
    {
        $agora = now();

        $alerta = Alerta::create([
            'nivel' => 'atencao',
            'pico_bruto' => 250,
            'iniciado_em' => $agora,
            'encerrado_em' => $agora,
            'simulado' => true,
        ]);

        return response()->json([
            'mensagem' => 'Teste registrado. O alerta simulado aparece no Histórico, marcado como Teste. Nada foi enviado a ninguém.',
            'id' => $alerta->id,
        ]);
    }
}
