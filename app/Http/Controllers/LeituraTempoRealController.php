<?php

namespace App\Http\Controllers;

use App\Models\Alerta;
use App\Models\Dispositivo;
use App\Models\Leitura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class LeituraTempoRealController extends Controller
{
    /**
     * Recebe a leitura do sensor (ESP32).
     *
     * O contrato com o firmware NÃO muda: o sensor envia {"valor": ..., "status": "..."}
     * e esta rota responde sempre {"mensagem": "Leitura atualizada"}.
     * O que é novo (gravar o alerta na tabela "alertas") roda dentro de try/catch:
     * se falhar, só é registrado no log e o sensor continua sendo atendido normalmente.
     */
    public function atualizar(Request $request)
    {
        $dados = $request->validate([
            'valor' => 'required|numeric',
            'status' => 'required|string|max:100'
        ]);

        $hora = now()->format('H:i:s');

        $sensor = $this->descobrirSensor($request);

        $this->gravarAmostra($dados, $sensor);

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
                    'hora_maximo' => $hora,
                    'alerta_id' => $this->abrirAlerta((int) round($dados['valor']), $sensor),
                    'dispositivo_id' => $sensor['id'] ?? null,
                ];
            } elseif ($dados['valor'] > $alerta['valor_maximo']) {
                $alerta['valor_maximo'] = $dados['valor'];
                $alerta['status_maximo'] = $dados['status'];
                $alerta['hora_maximo'] = $hora;

                $this->atualizarPico($alerta['alerta_id'] ?? null, (int) round($dados['valor']));
            }

            Cache::put('alerta_ativo', $alerta);
        } else {
            if ($alerta['ativo']) {
                $this->encerrarAlerta($alerta['alerta_id'] ?? null, (int) round($alerta['valor_maximo']));

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

    /**
     * Descobre de qual sensor veio a leitura. Nunca atrapalha o sensor: qualquer problema vira null.
     *
     * 1. Se o firmware mandar um token (cabeçalho "Authorization: Bearer ..." ou "X-Dispositivo-Token"),
     *    usa o sensor dono do token. Token desconhecido é ignorado (por enquanto o token é opcional).
     * 2. Se não vier token, e existir EXATAMENTE UM sensor ativo cadastrado, usa esse.
     * 3. Senão, a leitura fica sem sensor.
     *
     * Também marca o último envio do sensor, no máximo uma vez a cada 30 segundos.
     */
    private function descobrirSensor(Request $request): ?array
    {
        try {
            $sensor = null;
            $token = $request->bearerToken() ?: $request->header('X-Dispositivo-Token');

            if ($token) {
                $hash = Dispositivo::hashDoToken($token);

                $sensor = Cache::remember('dispositivo_token_' . $hash, 60, function () use ($hash) {
                    $d = Dispositivo::where('token_hash', $hash)->where('ativo', true)->first(['id', 'local_id']);

                    return $d ? ['id' => $d->id, 'local_id' => $d->local_id] : [];
                });
            }

            if (empty($sensor)) {
                $sensor = Cache::remember('dispositivo_unico', 60, function () {
                    $ativos = Dispositivo::where('ativo', true)->limit(2)->get(['id', 'local_id']);

                    return $ativos->count() === 1
                        ? ['id' => $ativos[0]->id, 'local_id' => $ativos[0]->local_id]
                        : [];
                });
            }

            if (empty($sensor)) {
                return null;
            }

            if (Cache::add('dispositivo_ping_' . $sensor['id'], 1, 30)) {
                try {
                    Dispositivo::whereKey($sensor['id'])->update(['ultimo_envio_em' => now()]);
                } catch (\Throwable $e) {
                    report($e); // falhar em marcar o último envio não pode fazer o sensor perder a ligação
                }
            }

            return $sensor;
        } catch (\Throwable $e) {
            report($e);

            return null;
        }
    }

    /**
     * Grava UMA leitura por minuto, por sensor (o sensor envia uma por segundo).
     * Qualquer problema vai só para o log e nunca atrapalha o sensor.
     */
    private function gravarAmostra(array $dados, ?array $sensor): void
    {
        try {
            $intervalo = (int) config('inogas.amostras.intervalo_segundos', 60);

            if (Cache::add('amostra_' . ($sensor['id'] ?? 'sem-sensor'), 1, $intervalo)) {
                Leitura::create([
                    'valor' => (int) round($dados['valor']),
                    'status' => $dados['status'],
                    'dispositivo_id' => $sensor['id'] ?? null,
                ]);
            }
        } catch (\Throwable $e) {
            report($e);
        }
    }

    private function nivel(int $valor): string
    {
        return $valor > config('inogas.limites.risco', 500) ? 'risco' : 'atencao';
    }

    private function abrirAlerta(int $valor, ?array $sensor = null): ?int
    {
        try {
            return Alerta::create([
                'dispositivo_id' => $sensor['id'] ?? null,
                'local_id' => $sensor['local_id'] ?? null,
                'nivel' => $this->nivel($valor),
                'pico_bruto' => $valor,
                'iniciado_em' => now(),
            ])->id;
        } catch (\Throwable $e) {
            report($e);

            return null;
        }
    }

    private function atualizarPico(?int $id, int $valor): void
    {
        if (! $id) {
            return;
        }

        try {
            Alerta::whereKey($id)->update([
                'pico_bruto' => $valor,
                'nivel' => $this->nivel($valor),
            ]);
        } catch (\Throwable $e) {
            report($e);
        }
    }

    private function encerrarAlerta(?int $id, int $pico): void
    {
        if (! $id) {
            return;
        }

        try {
            Alerta::whereKey($id)->update([
                'pico_bruto' => $pico,
                'nivel' => $this->nivel($pico),
                'encerrado_em' => now(),
            ]);
        } catch (\Throwable $e) {
            report($e);
        }
    }
}
